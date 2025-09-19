@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="fw-bold text-dark mb-4">Comparativo de Acessos (Range X vs Range Y)</h2>

    <form id="compare-form" class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">De (Range X)</label>
            <input type="date" id="fromX" name="fromX" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Até (Range X)</label>
            <input type="date" id="toX" name="toX" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">De (Range Y)</label>
            <input type="date" id="fromY" name="fromY" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Até (Range Y)</label>
            <input type="date" id="toY" name="toY" class="form-control" required>
        </div>
        <div class="col-12 my-2">
            <button type="submit" class="btn btn-primary">Comparar</button>
        </div>
    </form>

    <div class="card">
        <div class="card-header bg-dark text-white">Resultado</div>
        <div class="card-body">
            <h3 id="msg">Insira os dados para comparação</h3>
            <canvas id="compareChart" style="max-height: 600px;"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let chartInstance = null;

    function loadChart(fromX, toX, fromY, toY) {
        fetch(`{{ route('reports.recent_vs_old_stats') }}?fromX=${fromX}&toX=${toX}&fromY=${fromY}&toY=${toY}`)
            .then(res => res.json())
            .then(data => {
                if (chartInstance) chartInstance.destroy();

                const ctx = document.getElementById('compareChart').getContext('2d');
                document.getElementById('msg').style.display = 'none';
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            `Range X (${data.rangeX.from} → ${data.rangeX.to})`,
                            `Range Y (${data.rangeY.from} → ${data.rangeY.to})`
                        ],
                        datasets: [{
                            label: 'Cliques',
                            data: [data.rangeX.count, data.rangeY.count],
                            backgroundColor: [
                                'rgba(0, 123, 255, 0.7)',
                                'rgba(40, 167, 69, 0.7)'
                            ],
                            borderColor: [
                                'rgba(0, 123, 255, 1)',
                                'rgba(40, 167, 69, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.raw} cliques`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            });
    }

    document.getElementById('compare-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const fromX = document.getElementById('fromX').value;
        const toX   = document.getElementById('toX').value;
        const fromY = document.getElementById('fromY').value;
        const toY   = document.getElementById('toY').value;
        loadChart(fromX, toX, fromY, toY);
    });
});
</script>
@endpush
