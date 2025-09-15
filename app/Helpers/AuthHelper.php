<?php

if (!function_exists('current_user_id')) {
    /**
     * Retorna o ID do usuário autenticado, ou null se for acesso público.
     *
     * @param  \Illuminate\Http\Request|null  $request
     * @return int|null
     */
    function current_user_id($request = null)
    {
        $request = $request ?? request();

        // Ajuste aqui para detectar rotas públicas
        $isPublic = $request->routeIs('public.*'); // use o prefixo de suas rotas públicas

        return $isPublic ? null : auth()->id();
    }
}
