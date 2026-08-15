<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditoria extends Model
{
    protected $table = 'auditoria';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'acao',
        'tabela',
        'registro_id',
        'dados_antes',
        'dados_depois',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'dados_antes' => 'array',
        'dados_depois' => 'array',
        'created_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Registra uma ação de auditoria de forma conveniente.
     */
    public static function registrar(string $acao, string $tabela, int $registroId, ?array $antes = null, ?array $depois = null): self
    {
        return self::create([
            'usuario_id' => auth()->id(),
            'acao' => $acao,
            'tabela' => $tabela,
            'registro_id' => $registroId,
            'dados_antes' => $antes,
            'dados_depois' => $depois,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
