<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilsHelper;

class ReportController extends Controller
{
    /**
     * Acessos em tempo real
     */
    public function realtimeAccess()
    {
        // Total de cliques
        $totalClicks = LinkClick::count();

        // Distribuição por link (para o gráfico de doughnut principal)
        $clicksByLink = LinkClick::select('link_id', DB::raw('count(*) as total'))
            ->groupBy('link_id')
            ->with('link')
            ->get();

        $labels = $clicksByLink->map(fn($c) => $c->link->short_url ?? 'N/A');
        $data = $clicksByLink->pluck('total');

        // Cliques por dia (últimos 15 dias)
        $clicksPerDay = LinkClick::select(
            DB::raw('DATE(clicked_at) as date'),
            DB::raw('count(*) as total')
        )
            ->where('clicked_at', '>=', now()->subDays(15))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Dispositivos
        $deviceStats = LinkClick::select('device', DB::raw('count(*) as total'))
            ->groupBy('device')
            ->pluck('total', 'device');

        // Navegadores
        $browserStats = LinkClick::select('browser', DB::raw('count(*) as total'))
            ->groupBy('browser')
            ->pluck('total', 'browser');

        // Empacotar dados para o JS
        $reportData = [
            'labels' => $labels,
            'data' => $data,
            'clicksPerDay' => $clicksPerDay,
            'deviceStats' => $deviceStats,
            'browserStats' => $browserStats,
        ];

        return view('admin.links.reports.realtime_access', [
            'totalClicks' => $totalClicks,
            'reportData' => $reportData,
        ]);
    }

    /**
     * Relatório de uso geral (página de estatísticas)
     */
    public function usage()
    {
        return view('admin.links.reports.usage');
    }

    /**
     * Estatísticas de navegadores e dispositivos
     */
    public function usageStats()
    {
        // Total de acessos
        $totalAccesses = LinkClick::count();

        // Último acesso registrado
        $lastAccess = LinkClick::latest('clicked_at')->first();

        // Navegadores mais usados
        $browsers = LinkClick::selectRaw('browser, COUNT(*) as total')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->pluck('total', 'browser');

        // Dispositivos mais usados
        $devices = LinkClick::selectRaw('device, COUNT(*) as total')
            ->groupBy('device')
            ->orderByDesc('total')
            ->pluck('total', 'device');

        return response()->json([
            'total_accesses' => $totalAccesses,
            'last_access' => $lastAccess && $lastAccess->clicked_at
                ? \Carbon\Carbon::parse($lastAccess->clicked_at)->format('d/m/Y H:i:s')
                : null,
            'browsers' => $browsers,
            'devices' => $devices,
        ]);
    }

    /**
     * Relatório de localizações
     */
    public function locations()
    {
        return view('admin.links.reports.locations');
    }

    /**
     * Dados de estatísticas de localizações (JSON)
     */
    public function locationsStats()
    {
        $data = LinkClick::select(
            'country',
            'region',
            'city',
            'latitude',
            'longitude',
            DB::raw('COUNT(*) as total')
        )
            ->whereNotNull(['country', 'region', 'city', 'latitude', 'longitude'])
            ->groupBy('country', 'region', 'city', 'latitude', 'longitude')
            ->get();

        return response()->json($data);
    }

    public function hourlyAccess()
    {
        return view('admin.links.reports.hourly_access');
    }

    /**
     * Relatório de acessos por hora em um dia específico
     */

    public function hourlyAccessStats(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Data inválida'], 422);
        }

        // Agrupa por hora
        $results = LinkClick::selectRaw('HOUR(clicked_at) as hour, COUNT(*) as total')
            ->whereDate('clicked_at', $date)
            ->groupBy(DB::raw('HOUR(clicked_at)'))
            ->orderBy('hour')
            ->get();

        $hours = [];
        for ($i = 0; $i < 24; $i++) {
            $hours[$i] = ['hour' => $i, 'total' => 0, 'links' => []];
        }

        // Preenche total e links detalhados
        foreach ($results as $row) {
            $hour = $row->hour;
            $hours[$hour]['total'] = $row->total;

            // Detalhe por link nesta hora
            $links = LinkClick::select('link_id', DB::raw('COUNT(*) as count'))
                ->whereDate('clicked_at', $date)
                ->whereRaw('HOUR(clicked_at) = ?', [$hour])
                ->groupBy('link_id')
                ->get()
                ->map(fn($l) => [
                    'url' => optional($l->link)->original_url ?? 'URL desconhecida',
                    'count' => $l->count
                ]);
            $hours[$hour]['links'] = $links;
        }

        return response()->json(array_values($hours));
    }

    public function referrerAccess()
    {
        return view('admin.links.reports.referrer-access');
    }

    public function referrerAccessStats(Request $request)
    {
        $start = $request->query('start_date', date('Y-m-d'));
        $end = $request->query('end_date', date('Y-m-d'));

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $end)) {
            return response()->json(['error' => 'Data inválida'], 422);
        }

        // Referrers a serem excluídos: contém "verifica-acesso"
        $excludedPattern = '%verifica-acesso%';

        // Conta cliques por referrer no período, exceto links internos
        $results = LinkClick::select('referrer', DB::raw('COUNT(*) as total'))
            ->whereBetween(DB::raw('DATE(clicked_at)'), [$start, $end])
            ->where('referrer', 'NOT LIKE', $excludedPattern)
            ->groupBy('referrer')
            ->orderByDesc('total')
            ->get();

        // Contagem de cliques excluídos
        $excludedCount = LinkClick::whereBetween(DB::raw('DATE(clicked_at)'), [$start, $end])
            ->where('referrer', 'LIKE', $excludedPattern)
            ->count();

        return response()->json([
            'data' => $results,
            'excluded_count' => $excludedCount,
            'excluded_pattern' => 'verifica-acesso'
        ]);
    }

    public function recentVsOld()
    {
        return view('admin.links.reports.recent_vs_old');
    }

    public function recentVsOldStats(Request $request)
    {
        $fromX = $request->query('fromX');
        $toX = $request->query('toX');
        $fromY = $request->query('fromY');
        $toY = $request->query('toY');

        // Validação simples
        foreach (['fromX' => $fromX, 'toX' => $toX, 'fromY' => $fromY, 'toY' => $toY] as $k => $v) {
            if (!$v || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
                return response()->json(['error' => "Data inválida: {$k}"], 422);
            }
        }

        $countX = LinkClick::whereBetween('clicked_at', [$fromX . ' 00:00:00', $toX . ' 23:59:59'])->count();
        $countY = LinkClick::whereBetween('clicked_at', [$fromY . ' 00:00:00', $toY . ' 23:59:59'])->count();

        return response()->json([
            'rangeX' => ['from' => $fromX, 'to' => $toX, 'count' => $countX],
            'rangeY' => ['from' => $fromY, 'to' => $toY, 'count' => $countY],
        ]);
    }

}
