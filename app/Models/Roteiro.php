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
        'descricao',
        'tema',
        'duracao_horas',
        'nivel_dificuldade', // facil, medio, dificil
        'meio_transporte', // a_pe, bicicleta, carro, transporte_publico
        'acessivel_pcd',
        'orcamento_estimado',
        'distancia_km',
        'gerado_por_ia',
        'perfil_turista',
        'status'
    ];

    protected $casts = [
        'acessivel_pcd' => 'boolean',
        'gerado_por_ia' => 'boolean',
        'orcamento_estimado' => 'decimal:2',
        'distancia_km' => 'decimal:2'
    ];

    public function atrativos()
    {
        return $this->belongsToMany(Atrativo::class, 'roteiro_atrativo')
                    ->withPivot('ordem', 'tempo_estimado_minutos')
                    ->orderBy('pivot_ordem');
    }
}
