@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="fw-bold text-dark mb-4">Acessos por Horário do Dia</h2>

    {{-- Filtro de data --}}
    <div class="mb-3">
        <label for="access-date" class="form-label">Selecione o dia:</label>
        <input type="date" id="access-date" class="form-control" value="{{ date('Y-m-d') }}">
    </div>

    {{-- Gráfico --}}
    <div class="card shadow-sm rounded">
        <div class="card-header bg-info text-white">
            Total de Acessos por Hora
        </div>
        <div class="card-body">
            <canvas id="hourly-access-chart" height="75"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('hourly-access-chart').getContext('2d');
    const dateInput = document.getElementById('access-date');
    const currentHour = new Date().getHours();

    // Labels 0:00 - 23:00
    const labels = Array.from({length:24}, (_,i)=>i + ':00');

const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Acessos',
            data: Array(24).fill(0),
            borderColor: 'rgba(0, 123, 255, 1)',
            backgroundColor: function(context) {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) return null;
                const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                gradient.addColorStop(0, 'rgba(0, 123, 255, 0.05)');
                gradient.addColorStop(1, 'rgba(0, 123, 255, 0.3)');
                return gradient;
            },
            tension: 0.4,
            fill: true,
            pointRadius: 6,
            pointBackgroundColor: function(context) {
                return context.dataIndex === currentHour ? '#FF4136' : '#007bff';
            },
            pointHoverRadius: 8,
            linksByHour: Array(24).fill([]) // links detalhados
        }]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        return `Hora: ${context[0].label}`;
                    },
                    label: function(context) {
                        const hour = context.dataIndex;
                        const total = context.dataset.data[hour];
                        const links = context.dataset.linksByHour[hour] || [];
                        const maxLinksToShow = 5;

                        const truncate = (str, len = 40) => str.length > len ? str.substring(0, len) + '…' : str;

                        const lines = [`Total: ${total}`];

                        links.slice(0, maxLinksToShow).forEach(link => {
                            lines.push(truncate(link.url) + ` (${link.count})`);
                        });

                        if (links.length > maxLinksToShow) {
                            lines.push(`+${links.length - maxLinksToShow} link(s) adicional(is)`);
                        }

                        return lines;
                    }
                }
            }
        },
        scales: {
            y: { beginAtZero: true, stepSize: 1 },
            x: { ticks: { callback: (val, index) => labels[index] } }
        }
    }
});

    function fetchData(date) {
        fetch(`{{ route('reports.hourly_access_stats') }}?date=${date}`)
            .then(res => res.json())
            .then(data => {
                const totals = Array(24).fill(0);
                const linksByHour = Array(24).fill([]).map(()=>[]);

                data.forEach(hourData => {
                    const h = parseInt(hourData.hour);
                    totals[h] = hourData.total ?? 0;
                    linksByHour[h] = hourData.links ?? [];
                });

                chart.data.datasets[0].data = totals;
                chart.data.datasets[0].linksByHour = linksByHour;
                chart.update();
            })
            .catch(err => console.error('Erro ao carregar dados:', err));
    }

    fetchData(dateInput.value);
    dateInput.addEventListener('change', function() {
        fetchData(this.value);
    });
});
</script>
@endpush
