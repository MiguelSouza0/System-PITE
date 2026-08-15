<?php

namespace App\Http\Middleware;

use App\Models\SiteVisita;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisits
{
    /**
     * Registra o acesso ao portal no banco de dados.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Apenas requisições GET com status 200 no portal
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            try {
                SiteVisita::registrar($request);
            } catch (\Throwable $e) {
                // Silencia para nunca impactar a navegação do usuário
            }
        }

        return $response;
    }
}
