<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roteiro extends Model
{
    use HasFactory;

    protected $table = 'roteiros';

    protected $fillable = [
        'titulo',
        'slug',
        'descricao',
        'duracao_estimada_horas',
        'nivel_dificuldade',
        'atrativos_ids',
        'perfil_publico_alvo',
        'gerado_por_ia',
        'ativo'
    ];

    protected $casts = [
        'duracao_estimada_horas' => 'integer',
        'atrativos_ids' => 'array',
        'gerado_por_ia' => 'boolean',
        'ativo' => 'boolean'
    ];

    /**
     * Atrativos do roteiro (via tabela pivot com ordem de visitação).
     */
    public function atrativos()
    {
        return $this->belongsToMany(Atrativo::class, 'roteiro_atrativo')
                    ->withPivot('ordem', 'tempo_estimado', 'observacao')
                    ->orderByPivot('ordem')
                    ->withTimestamps();
    }
}
