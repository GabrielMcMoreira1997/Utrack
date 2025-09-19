@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="fw-bold text-dark mb-4">Relatório de Navegadores & Dispositivos</h2>

    <p class="text-muted mb-4">
        Este painel apresenta informações sobre os navegadores e dispositivos mais utilizados para acessar os links encurtados. 
        Os dados são atualizados em tempo real ao carregar a página.
    </p>

    <!-- KPIs -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Total de Acessos</h5>
                    <h2 class="fw-bold" id="kpi-total-access">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Último Acesso</h5>
                    <h2 class="fw-bold" id="kpi-last-access">—</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de navegadores -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">Navegadores mais utilizados</div>
                <div class="card-body">
                    <canvas id="browsersChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de dispositivos -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">Dispositivos mais utilizados</div>
                <div class="card-body">
                    <canvas id="devicesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <p class="text-muted mt-2">
        Dicas: Utilize estas informações para entender o perfil de acesso dos usuários, otimizar compatibilidade e priorizar melhorias para os dispositivos e navegadores mais comuns.
    </p>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const browsersCtx = document.getElementById('browsersChart')?.getContext('2d');
    const devicesCtx = document.getElementById('devicesChart')?.getContext('2d');

    if (!browsersCtx || !devicesCtx) return;

    const browsersChart = new Chart(browsersCtx, {
        type: 'pie',
        data: { labels: [], datasets: [{ data: [], backgroundColor: ['#3498DB','#E74C3C','#F1C40F','#9B59B6','#2ECC71'] }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const devicesChart = new Chart(devicesCtx, {
        type: 'doughnut',
        data: { labels: [], datasets: [{ data: [], backgroundColor: ['#2ECC71','#3498DB','#F1C40F','#9B59B6'] }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    fetch("{{ route('reports.usage_stats') }}")
        .then(res => res.json())
        .then(data => {
            // Atualiza KPIs
            document.getElementById('kpi-total-access').textContent = data.total_accesses ?? 0;
            document.getElementById('kpi-last-access').textContent = data.last_access ?? '—';

            // Atualiza navegadores
            browsersChart.data.labels = Object.keys(data.browsers);
            browsersChart.data.datasets[0].data = Object.values(data.browsers);
            browsersChart.update();

            // Atualiza dispositivos
            devicesChart.data.labels = Object.keys(data.devices);
            devicesChart.data.datasets[0].data = Object.values(data.devices);
            devicesChart.update();
        })
        .catch(err => console.error("Erro ao carregar estatísticas:", err));
});
</script>
@endpush
