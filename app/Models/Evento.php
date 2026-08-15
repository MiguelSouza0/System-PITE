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
        'ativo',
        'status_aprovacao',
        'aprovado_por_user_id',
        'observacoes_admin',
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'gratuito' => 'boolean',
        'ativo' => 'boolean',
        'preco_ingresso' => 'decimal:2'
    ];

    // --- Relacionamentos ---

    public function atrativo()
    {
        return $this->belongsTo(Atrativo::class);
    }

    public function aprovador()
    {
        return $this->belongsTo(User::class, 'aprovado_por_user_id');
    }

    // --- Scopes de Status de Aprovação ---

    /**
     * Somente registros aprovados e ativos — visíveis no portal público, mapa e turista.
     */
    public function scopeVisivelPortal($query)
    {
        return $query->where('status_aprovacao', 'aprovado')->where('ativo', true);
    }

    public function scopeAprovado($query)
    {
        return $query->where('status_aprovacao', 'aprovado');
    }

    public function scopePendente($query)
    {
        return $query->where('status_aprovacao', 'pendente');
    }

    public function scopeSuspenso($query)
    {
        return $query->where('status_aprovacao', 'suspenso');
    }
}
