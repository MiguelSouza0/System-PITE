<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Midia extends Model
{
    protected $fillable = [
        'tipo',
        'url',
        'thumbnail',
        'titulo',
        'descricao_alt',
        'autoria',
        'autorizado',
        'entidade_id',
        'entidade_type',
    ];

    protected $casts = [
        'autorizado' => 'boolean',
    ];

    /**
     * Relação polimórfica — pode pertencer a Atrativo, Evento ou Empreendedor.
     */
    public function entidade(): MorphTo
    {
        return $this->morphTo();
    }
}
