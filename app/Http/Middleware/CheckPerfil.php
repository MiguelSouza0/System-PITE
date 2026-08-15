<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPerfil
{
    /**
     * Verifica se o usuário logado possui um dos perfis permitidos.
     *
     * Uso nas rotas: ->middleware('perfil:prefeito,secretario')
     */
    public function handle(Request $request, Closure $next, string ...$perfis): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $perfilUsuario = strtolower(auth()->user()->perfil->slug ?? '');

        if (!in_array($perfilUsuario, $perfis)) {
            abort(403, 'Acesso não autorizado para o perfil: ' . $perfilUsuario);
        }

        return $next($request);
    }
}
