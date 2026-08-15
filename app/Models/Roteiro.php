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
        'ponto_partida',
        'ponto_chegada',
        'duracao_estimada_horas',
        'distancia_total_km',
        'nivel_dificuldade',
        'meio_transporte',
        'acessivel_pne',
        'faixa_etaria',
        'orcamento_nivel',
        'tema',
        'caracteristicas_percurso',
        'servicos_disponiveis',
        'orientacoes_seguranca',
        'polylines_coordenadas',
        'atrativos_ids',
        'perfil_publico_alvo',
        'gerado_por_ia',
        'validado_por_user_id',
        'resumo_ia',
        'ativo'
    ];

    protected $casts = [
        'duracao_estimada_horas' => 'integer',
        'distancia_total_km' => 'decimal:2',
        'acessivel_pne' => 'boolean',
        'caracteristicas_percurso' => 'array',
        'servicos_disponiveis' => 'array',
        'orientacoes_seguranca' => 'array',
        'polylines_coordenadas' => 'array',
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

    /**
     * Validador humano do roteiro (servidor ou secretário).
     */
    public function validador()
    {
        return $this->belongsTo(User::class, 'validado_por_user_id');
    }

    // --- Scopes ---

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeAcessivel($query)
    {
        return $query->where('acessivel_pne', true);
    }

    public function scopePorTema($query, string $tema)
    {
        return $query->where('tema', $tema);
    }

    public function scopePorDificuldade($query, string $dificuldade)
    {
        return $query->where('nivel_dificuldade', $dificuldade);
    }

    public function scopePorMeioTransporte($query, string $meio)
    {
        return $query->where('meio_transporte', $meio);
    }

    // --- Helpers de Apresentação ---

    public function getTempoFormatadoAttribute(): string
    {
        $horas = $this->duracao_estimada_horas ?? 1;
        if ($horas < 1) {
            return '45 min';
        } elseif ($horas === 1) {
            return '1 hora';
        } elseif ($horas >= 24) {
            $dias = round($horas / 24);
            return $dias . ($dias > 1 ? ' dias' : ' dia');
        }
        return $horas . ' horas';
    }

    public function getDistanciaFormatadaAttribute(): string
    {
        $dist = (float) ($this->distancia_total_km ?? 0);
        if ($dist <= 0) {
            return 'Percurso central';
        }
        return number_format($dist, 1, ',', '.') . ' km';
    }

    public function getMeioTransporteLabelAttribute(): string
    {
        $labels = [
            'a_pe' => '🚶 A Pé',
            'bicicleta' => '🚴 Bicicleta',
            'carro' => '🚗 Carro / Moto',
            'transporte_publico' => '🚌 Ônibus Turístico',
            'misto' => '🔀 Percurso Misto',
        ];
        return $labels[$this->meio_transporte] ?? '🚶 A Pé';
    }

    public function getNivelDificuldadeLabelAttribute(): string
    {
        $labels = [
            'facil' => '🟢 Fácil (Leve)',
            'medio' => '🟡 Moderado',
            'dificil' => '🔴 Difícil / Avançado',
        ];
        return $labels[$this->nivel_dificuldade] ?? '🟢 Fácil';
    }

    public function getTemaLabelAttribute(): string
    {
        $temas = [
            'cultural' => '🏛️ Histórico & Cultural',
            'ecoturismo' => '🌲 Ecoturismo & Natureza',
            'gastronomia' => '🍽️ Gastronomia Local',
            'aventura' => '🧗 Aventura & Trilhas',
            'religioso' => '⛪ Fé & Tradições',
            'compras' => '🛍️ Artesanato & Comércio',
            'familia' => '👨‍👩‍👧 Familiar & Infantil',
            'misto' => '✨ Experiência Completa'
        ];
        return $temas[$this->tema] ?? ucfirst($this->tema ?? 'Geral');
    }

    public function getOrcamentoLabelAttribute(): string
    {
        $orcamentos = [
            'gratuito' => '🆓 100% Gratuito',
            'economico' => '💲 Econômico (até R$ 40)',
            'moderado' => '💲💲 Moderado (R$ 40 - R$ 120)',
            'premium' => '💲💲💲 Completo (R$ 120+)',
        ];
        return $orcamentos[$this->orcamento_nivel] ?? 'Econômico';
    }
}
