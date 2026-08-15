<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacao extends Model
{
    protected $table = 'notificacoes';

    protected $fillable = [
        'titulo',
        'mensagem',
        'tipo',
        'criterio_envio',
        'enviado_em',
        'criado_por',
    ];

    protected $casts = [
        'criterio_envio' => 'array',
        'enviado_em' => 'datetime',
    ];

    public function criador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }
}
