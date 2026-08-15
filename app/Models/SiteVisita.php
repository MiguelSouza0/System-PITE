<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SiteVisita extends Model
{
    protected $table = 'site_visitas';

    protected $fillable = [
        'ip_hash',
        'url',
        'metodo',
        'dispositivo',
        'navegador',
        'user_id',
        'data_visita',
    ];

    protected $casts = [
        'data_visita' => 'date',
    ];

    /**
     * Registra uma visita ao portal em conformidade com a LGPD (IP anonimizado com SHA-256).
     */
    public static function registrar(Request $request): ?self
    {
        // Ignora requisições de assets, debugbar ou api interna
        $path = $request->path();
        if (
            str_starts_with($path, '_') ||
            str_starts_with($path, 'api/') ||
            str_ends_with($path, '.js') ||
            str_ends_with($path, '.css') ||
            str_ends_with($path, '.png') ||
            str_ends_with($path, '.jpg')
        ) {
            return null;
        }

        $userAgent = $request->userAgent() ?? '';
        $dispositivo = 'desktop';
        if (preg_match('/(mobile|android|iphone|ipad|ipod)/i', $userAgent)) {
            $dispositivo = 'mobile';
        } elseif (preg_match('/(tablet)/i', $userAgent)) {
            $dispositivo = 'tablet';
        }

        // Anonimização LGPD: hash com salt diário para não expor IP real
        $ipHash = hash('sha256', ($request->ip() ?? '127.0.0.1') . date('Y-m-d'));

        return self::create([
            'ip_hash' => $ipHash,
            'url' => '/' . ltrim($path, '/'),
            'metodo' => $request->method(),
            'dispositivo' => $dispositivo,
            'navegador' => substr($userAgent, 0, 50),
            'user_id' => auth()->id(),
            'data_visita' => now()->toDateString(),
        ]);
    }
}
