@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="fw-bold text-dark mb-4">Acessos por Referrer</h2>

        {{-- Filtro de intervalo de datas --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="start-date" class="form-label">Data Inicial:</label>
                <input type="date" id="start-date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label for="end-date" class="form-label">Data Final:</label>
                <input type="date" id="end-date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        {{-- Gráfico --}}
        <div class="card shadow-sm rounded">
            <div class="card-header bg-success text-white">
                Top 10 Referrers
            </div>
            <div class="card-body">
                <canvas id="referrer-chart" height="75"></canvas>
            </div>
        </div>

        <div class="mb-3">
            <div class="alert alert-info">
                1 - Links que possuem senha foram excluídos do gráfico.<br>
                2 - Alguns referrers não podem ser exibidos por conterem dados sensíveis, privacidade ou por bloqueio.
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('referrer-chart').getContext('2d');
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');

            const chart = new Chart(ctx, {
                type: 'bar',
                data: { labels: [], datasets: [{ label: 'Cliques', data: [], backgroundColor: 'rgba(40, 167, 69, 0.7)', borderColor: 'rgba(40, 167, 69, 1)', borderWidth: 1 }] },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) { return `${context.dataset.label}: ${context.parsed.y}`; },
                                title: function (context) { return context[0].label; }
                            }
                        }
                    },
                    scales: { y: { beginAtZero: true, stepSize: 1 }, x: { ticks: { autoSkip: false } } }
                }
            });

            function fetchData() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                fetch(`{{ route('reports.referrer_stats') }}?start_date=${startDate}&end_date=${endDate}`)
                    .then(res => res.json())
                    .then(resp => {
                        const data = resp.data;
                        const excludedCount = resp.excluded_count;
                        const excludedReferrer = resp.excluded_referrer;

                        // Top 10 referrers
                        const top10 = data.slice(0, 10);
                        chart.data.labels = top10.map(d => d.referrer ?? 'Direto');
                        chart.data.datasets[0].data = top10.map(d => d.total ?? 0);
                        chart.update();
                    })
                    .catch(err => console.error('Erro ao carregar dados:', err));
            }
            fetchData();

            startDateInput.addEventListener('change', fetchData);
            endDateInput.addEventListener('change', fetchData);
        });
    </script>
@endpush