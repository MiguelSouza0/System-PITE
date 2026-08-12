<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'slug',
        'descricao',
        'data_inicio',
        'data_fim',
        'local',
        'atrativo_id',
        'preco_ingresso',
        'organizador',
        'gratuito',
        'ativo'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'gratuito' => 'boolean',
        'ativo' => 'boolean',
        'preco_ingresso' => 'decimal:2'
    ];

    public function atrativo()
    {
        return $this->belongsTo(Atrativo::class);
    }
}
