<?php

if (!function_exists('getReferrer')) {
    /**
     * Retorna o referrer do clique de forma confiável.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return string|null
     */
    function getReferrer($request = null)
    {
        $request = $request ?? request();

        // 1. Tenta query param ?ref=
        $ref = $request->query('ref');
        if (!empty($ref)) {
            return $ref;
        }

        // 2. Tenta header HTTP_REFERER
        $ref = $request->server('HTTP_REFERER');
        if (!empty($ref)) {
            return $ref;
        }

        // 3. Fallback: document.referrer enviado via JS
        $ref = $request->input('referrer'); 
        if (!empty($ref)) {
            return $ref;
        }

        // Nenhum disponível
        return null;
    }
}
