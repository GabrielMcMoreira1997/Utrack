@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="fw-bold text-dark mb-2">Relatório de Localizações</h2>

    <p class="text-muted mb-4">
        Este relatório exibe os países e cidades de onde os acessos foram realizados.
        O mapa é interativo: é possível dar zoom para visualizar os acessos por cidade.
    </p>

    {{-- Resumo Estatístico --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-info">
                <div class="card-header bg-info text-white">Estatísticas Gerais</div>
                <div class="card-body" id="stats-summary">
                    <p>Total de acessos: <strong>—</strong></p>
                    <p>País com mais acessos: <strong>—</strong></p>
                    <p>Cidade com mais acessos: <strong>—</strong></p>
                    <p>Número de países: <strong>—</strong></p>
                    <p>Número de cidades: <strong>—</strong></p>
                </div>
            </div>
        </div>

        {{-- Top 5 cidades --}}
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Cidades com mais acessos</div>
                <div class="card-body">
                    <ol id="top-cities">
                        <li>—</li>
                        <li>—</li>
                        <li>—</li>
                        <li>—</li>
                        <li>—</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Mapa --}}
    <div class="card">
        <div class="card-header bg-info text-white">Acessos por Localização</div>
        <div class="card-body" style="height: 500px;">
            <div id="map" style="width: 100%; height: 100%;"></div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([0, 0], 2); // visão inicial mundo

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    fetch("{{ route('reports.locations_stats') }}")
        .then(res => res.json())
        .then(data => {
            if (!data || !data.length) {
                console.warn("Nenhum dado de localização.");
                return;
            }

            const points = data
                .map(loc => {
                    const lat = loc.latitude !== null ? parseFloat(loc.latitude) : NaN;
                    const lng = loc.longitude !== null ? parseFloat(loc.longitude) : NaN;
                    const total = loc.total !== undefined ? Number(loc.total) : 0;
                    return Object.assign({}, loc, { latitude: lat, longitude: lng, total });
                })
                .filter(loc => !Number.isNaN(loc.latitude) && !Number.isNaN(loc.longitude));

            if (!points.length) {
                console.warn("Nenhum ponto com coordenadas válidas.");
                return;
            }

            // Estatísticas
            const totalAccesses = points.reduce((sum, p) => sum + p.total, 0);
            const countries = [...new Set(points.map(p => p.country))];
            const cities = [...new Set(points.map(p => p.city))];

            const maxCountry = points.reduce((acc, p) => {
                acc[p.country] = (acc[p.country] || 0) + p.total;
                return acc;
            }, {});
            const topCountry = Object.entries(maxCountry).sort((a,b)=>b[1]-a[1])[0]?.[0] ?? '—';

            const topCity = points.sort((a,b)=>b.total - a.total)[0]?.city ?? '—';

            document.getElementById('stats-summary').innerHTML = `
                <p>Total de acessos: <strong>${totalAccesses}</strong></p>
                <p>País com mais acessos: <strong>${topCountry}</strong></p>
                <p>Cidade com mais acessos: <strong>${topCity}</strong></p>
                <p>Número de países: <strong>${countries.length}</strong></p>
                <p>Número de cidades: <strong>${cities.length}</strong></p>
            `;

            // Top 5 cidades
            const top5 = points.sort((a,b)=>b.total-a.total).slice(0,5);
            const ol = document.getElementById('top-cities');
            ol.innerHTML = top5.map(c => `<li>${c.city} — ${c.total}</li>`).join('');

            // Escala de raio e cor
            const totals = points.map(p => p.total);
            const minTotal = Math.min(...totals);
            const maxTotal = Math.max(...totals);
            const minRadius = 6;
            const maxRadius = 30;

            function scaleRadius(count) {
                if (maxTotal === minTotal) return (minRadius + maxRadius) / 2;
                const t = (count - minTotal) / (maxTotal - minTotal);
                return Math.max(minRadius, Math.round(minRadius + t * (maxRadius - minRadius)));
            }

            function colorFor(count) {
                if (maxTotal === minTotal) return 'hsl(210, 90%, 50%)';
                const ratio = (count - minTotal) / (maxTotal - minTotal);
                const hue = (1 - ratio) * 210;
                return `hsl(${hue}, 85%, 45%)`;
            }

            const markers = [];
            points.forEach(loc => {
                const radius = scaleRadius(loc.total);
                const color = colorFor(loc.total);

                const marker = L.circleMarker([loc.latitude, loc.longitude], {
                    radius,
                    color,
                    fillColor: color,
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.65
                }).bindPopup(`
                    <strong>${loc.city ?? '—'}</strong><br>
                    ${loc.region ? loc.region + '<br>' : ''}
                    <small>${loc.country ?? ''}</small><br>
                    <strong>Acessos:</strong> ${loc.total}
                `).addTo(map);

                markers.push(marker);
            });

            if (markers.length === 1) {
                map.setView(markers[0].getLatLng(), 8);
            } else {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.15));
            }
        })
        .catch(err => console.error("Erro ao carregar localizações:", err));
});
</script>
@endpush
@endsection
