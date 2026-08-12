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
        'descricao',
        'categoria_id',
        'data_inicio',
        'data_fim',
        'local',
        'latitude',
        'longitude',
        'organizador',
        'contato',
        'capacidade',
        'gratuito',
        'valor_ingresso',
        'faixa_etaria',
        'acessibilidade_descricao',
        'status', // rascunho, aprovado, cancelado
        'destaque'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'gratuito' => 'boolean',
        'destaque' => 'boolean',
        'valor_ingresso' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
