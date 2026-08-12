<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ocorrencia extends Model
{
    protected $fillable = [
        'local',
        'categoria',
        'data',
        'gravidade',
        'situacao',
        'descricao',
        'latitude',
        'longitude',
        'registrado_por',
    ];

    protected $casts = [
        'data' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
