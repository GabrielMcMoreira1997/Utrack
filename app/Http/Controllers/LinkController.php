<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Support\Str;
use App\Events\LinkClicksUpdated;
use App\Events\LinkAccessed;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



class LinkController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);


        if (empty($request->short_code)) {
            $shortCode = \Str::random(6);
        } else {
            $shortCode = $request->short_code;

            if (Link::where(['short_code' => $shortCode, 'company_id' => Auth()->user()->company_id])->exists()) {
                return response()->json(['error' => 'O código curto personalizado já está em uso.'], 409);
            }
        }

        /*
         * BUG: Se tiver autenticado e vier da página pública, o user_id não fica null
         * Contexto: O problema ocorre porque a sessão do usuário autenticado persiste mesmo quando ele acessa a página pública.
         * Resolução: Se vier da página pública, o user_id deve ser null, caso contrário, deve ser o ID do usuário autenticado.
         */

        $expiresAt = null;
        if (!Auth()->check()) {
            // PÚBLICO sempre expira amanhã
            $expiresAt = now()->addDay();
        } else {
            // AUTENTICADO usa o valor enviado ou null se não informado
            $expiresAt = $request->input('expire_at', null);
        }

        $link = Link::create([
            'original_url' => $request->url,
            'short_code' => $shortCode,
            'user_id' => current_user_id($request),
            'company_id' => Auth()->user()->company_id,
            'description' => $request->input('description', null),
            'password' => $request->input('password', null),
            'expires_at' => $expiresAt,
        ]);

        $tagsInput = $request->input('tags', []);

        $tagsIds = [];
        foreach ($tagsInput as $tag) {
            if (is_numeric($tag)) {
                $tagsIds[] = (int) $tag;
            } else {
                $newTag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tag, 'company_id' => Auth()->user()->company_id], // condições de busca
                    ['company_id' => Auth()->user()->company_id, 'user_id' => Auth()->id()] // valores para criar, se não encontrar
                );

                $tagsIds[] = $newTag->id;
            }
        }

        $link->tags()->sync($tagsIds);

        if (Auth()) {
            return redirect()->route('dashboard')->with('success', 'Link encurtado com sucesso!');
        }

        return response()->json([
            'short_url' => url($shortCode)
        ]);
    }

    public function redirect($shortCode)
    {
        $link = Link::where('short_code', $shortCode)->firstOrFail();

        // Verifica se o link está expirado
        if ($link->expires_at && now()->greaterThan($link->expires_at)) {
            return response()->view('admin.links.errors.401', [], 401);
        }

        // Atualiza contador total
        $link->increment('clicks');

        // Detecta device e browser
        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());

        $device = 'desktop';
        if ($agent->isMobile())
            $device = 'smartphone';
        elseif ($agent->isTablet())
            $device = 'tablet';

        // Geolocalização aproximada via IP (ex: usando stevebauman/location)
        $location = Location::get('138.185.40.154');
        LinkClick::create([
            'link_id' => $link->id,
            'country' => $location->countryName ?? null,
            'region' => $location->regionName ?? null,
            'city' => $location->cityName ?? null,
            'device' => $device,
            'os' => $agent->platform(),
            'os_version' => $agent->version($agent->platform()),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'language' => substr(request()->server('HTTP_ACCEPT_LANGUAGE') ?? 'unknown', 0, 5),
            'referrer' => request()->server('HTTP_REFERER'),
            'clicked_at' => now(),
        ]);

        // Emitir evento para Echo atualizar relatórios em tempo real
        broadcast(new LinkClicksUpdated());
        broadcast(new LinkAccessed($link, $link->original_url));

        return redirect()->away($link->original_url);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $link = Link::findOrFail($id);

        if (empty($request->short_code)) {
            $shortCode = $link->short_code;
        } else {
            $shortCode = $request->short_code;
            if (
                Link::where([
                    ['short_code', '=', $shortCode],
                    ['company_id', '=', Auth()->user()->company_id]
                ])
                ->where('id', '!=', $link->id)
                ->exists()
            ) {
                return response()->json(['error' => 'O código curto personalizado já está em uso.'], 409);
            }
        }

        $link->original_url = $request->url;
        $link->short_code = $shortCode;
        $link->user_id = current_user_id($request);
        $link->company_id = Auth()->user()->company_id;
        $link->expires_at = $request->input('expire_at', now()->addDay());
        $link->description = $request->input('description', $link->description);
        $link->password = $request->input('password', $link->password);
        $link->save();

        $tagsInput = $request->input('tags', []);

        $tagsIds = [];
        foreach ($tagsInput as $tag) {
            if (is_numeric($tag)) {
                $tagsIds[] = (int) $tag;
            } else {
                $newTag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tag, 'company_id' => Auth()->user()->company_id],
                    ['company_id' => Auth()->user()->company_id, 'user_id' => Auth()->id()]
                );
                $tagsIds[] = $newTag->id;
            }
        }

        $link->tags()->sync($tagsIds);
        return redirect()->route('dashboard')->with('success', 'Link atualizado com sucesso!');        
    }

    public function destroy($id)
    {
        $link = Link::findOrFail($id);
        $link->delete();

        return redirect()->route('dashboard')->with('success', 'Link excluído com sucesso.');
    }

    public function report()
    {
        // Lista de links (usada no gráfico principal)
        $links = Link::all();

        // Totais básicos
        $totalClicks = $links->sum('clicks');
        $avgClicksPerLink = $links->count() ? round($totalClicks / $links->count(), 2) : 0;

        // Inicializa variáveis padrão (caso não exista tabela de cliques detalhados)
        $clicksPerDay = collect();
        $deviceStats = [];
        $browserStats = [];
        $languages = collect();
        $lastClick = null;

        // Se existir a tabela 'link_clicks', usamos ela para relatórios mais precisos
        if (Schema::hasTable('link_clicks')) {
            // Cliques por dia (data + total)
            $clicksPerDay = \App\Models\LinkClick::selectRaw('DATE(clicked_at) as date, count(*) as total')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->map(function ($r) {
                    return ['date' => (string) $r->date, 'total' => (int) $r->total];
                });

            // Distribuição por dispositivo
            $deviceStats = LinkClick::selectRaw('COALESCE(NULLIF(device, \'\'), "unknown") as device, count(*) as total')
                ->groupBy('device')
                ->orderByDesc('total')
                ->pluck('total', 'device')
                ->toArray();

            // Distribuição por navegador
            $browserStats = LinkClick::selectRaw('COALESCE(NULLIF(browser, \'\'), "unknown") as browser, count(*) as total')
                ->groupBy('browser')
                ->orderByDesc('total')
                ->pluck('total', 'browser')
                ->toArray();

            // Idiomas mais usados
            $languages = LinkClick::selectRaw('COALESCE(NULLIF(language, \'\'), "unknown") as language, count(*) as total')
                ->whereNotNull('language')
                ->groupBy('language')
                ->orderByDesc('total')
                ->pluck('total', 'language'); // Collection keyed por idioma

            // Último clique registrado
            $lastClick = LinkClick::latest('clicked_at')->first();

            $locations = LinkClick::select('country', DB::raw('COUNT(*) as count'))
                ->groupBy('country')
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => $item->country ?: 'Unknown',
                        'value' => $item->count,
                    ];
                });
        } else {
            // fallback simples: construir clicksPerDay a partir do campo clicks dos links
            // (apenas para exibição mínima; não substitui registros reais por clique)
            $clicksPerDay = collect(); // vazio — recomendo criar a tabela link_clicks
        }

        return view('admin.links.graph.report', compact(
            'links',
            'clicksPerDay',
            'deviceStats',
            'browserStats',
            'languages',
            'lastClick',
            'totalClicks',
            'avgClicksPerLink',
            'locations'
        ));
    }

    public function generateShortCode()
    {
        return Str::random(6);
    }
}

