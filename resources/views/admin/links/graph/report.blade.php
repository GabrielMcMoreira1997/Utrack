@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4 space-y-6">

    <!-- MÉTRICAS RÁPIDAS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 shadow-sm rounded-xl text-center">
            <h6 class="text-gray-500 uppercase mb-2">Total de Cliques</h6>
            <h3 class="text-2xl font-bold text-green-500">{{ $links->sum('clicks') }}</h3>
        </div>
        <div class="bg-white p-4 shadow-sm rounded-xl text-center">
            <h6 class="text-gray-500 uppercase mb-2">CTR (simulado)</h6>
            <h3 class="text-2xl font-bold text-blue-500">{{ number_format(($links->sum('clicks') / max($links->count(),1)) * 10, 2) }}%</h3>
        </div>
        <div class="bg-white p-4 shadow-sm rounded-xl text-center">
            <h6 class="text-gray-500 uppercase mb-2">Idiomas + usados</h6>
            <h5 class="text-lg font-semibold text-gray-800">{{ $languages->keys()->take(2)->join(', ') ?? '-' }}</h5>
        </div>
        <div class="bg-white p-4 shadow-sm rounded-xl text-center">
            <h6 class="text-gray-500 uppercase mb-2">Último Acesso</h6>
            <h5 class="text-lg font-semibold text-gray-800">{{ $lastClick->created_at->diffForHumans() ?? 'Nenhum' }}</h5>
        </div>
    </div>

    <!-- LINHA PRINCIPAL -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Gráfico de Cliques -->
        <div class="lg:col-span-8 bg-white p-6 rounded-xl shadow-sm flex flex-col" style="height: 350px;">
            <h3 class="text-lg font-semibold mb-4 text-green-600 flex items-center gap-2">
                <i class="fas fa-signal"></i> Distribuição de Cliques
            </h3>
            <div class="flex-1">
                <canvas id="clicksChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Log de Acessos -->
        <div class="lg:col-span-4 bg-white p-6 rounded-xl shadow-sm flex flex-col" style="height: 350px;">
            <h3 class="text-lg font-semibold mb-4 text-blue-600 flex items-center gap-2">
                <i class="fas fa-clock"></i> Acessos Recentes
            </h3>
            <div id="log-container" class="flex-1 overflow-y-auto space-y-2">
                <p class="text-gray-400 text-center" id="log-placeholder">Nenhum acesso recente.</p>
            </div>
        </div>
    </div>

    <!-- GRÁFICOS AGREGADOS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-4">
        <div class="lg:col-span-6 bg-white p-6 rounded-xl shadow-sm flex flex-col" style="height: 300px;">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center gap-2">
                <i class="fas fa-calendar-day"></i> Cliques por Dia
            </h3>
            <div class="flex-1">
                <canvas id="clicksPerDayChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-sm flex flex-col" style="height: 300px;">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center gap-2">
                <i class="fas fa-mobile-alt"></i> Dispositivos
            </h3>
            <div class="flex-1">
                <canvas id="devicesChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-sm flex flex-col" style="height: 300px;">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center gap-2">
                <i class="fas fa-globe"></i> Navegadores
            </h3>
            <div class="flex-1">
                <canvas id="browsersChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.linkReportData = {
        labels: @json($links->pluck("short_code") ?? []),
        data: @json($links->pluck("clicks") ?? []),
        clicksPerDay: @json($clicksPerDay ?? []),
        deviceStats: @json($deviceStats ?? []),
        browserStats: @json($browserStats ?? [])
    };
</script>
<script src="{{ asset('js/link-report.js') }}"></script>
@endpush
@endsection
