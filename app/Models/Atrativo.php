<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atrativo extends Model
{
    use HasFactory;

    protected $table = 'atrativos';

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'descricao_curta',
        'categoria_id',
        'latitude',
        'longitude',
        'endereco',
        'cep',
        'numero',
        'bairro',
        'cidade',
        'uf',
        'horario_funcionamento',
        'preco_medio',
        'niveis_acessibilidade',
        'caracteristicas_esg',
        'destaque',
        'ativo',
        'status_aprovacao',
        'aprovado_por_user_id',
        'observacoes_admin',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'preco_medio' => 'decimal:2',
        'niveis_acessibilidade' => 'array',
        'caracteristicas_esg' => 'array',
        'destaque' => 'boolean',
        'ativo' => 'boolean'
    ];

    // --- Relacionamentos ---

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
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
