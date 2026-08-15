<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiPlanoTurismo extends Model
{
    use HasFactory;

    protected $table = 'ai_planos_turismo';

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'dias',
        'itens',
        'preferencias',
        'status',
        'sessao_chat_id',
    ];

    protected $casts = [
        'itens' => 'array',
        'preferencias' => 'array',
        'dias' => 'integer',
    ];

    // --- Relacionamentos ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --- Scopes ---

    public function scopeDoUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeAtivos($query)
    {
        return $query->whereIn('status', ['rascunho', 'ativo']);
    }

    // --- Helpers ---

    /**
     * Retorna os itens organizados por dia.
     */
    public function itensPorDia(): array
    {
        $rawItens = $this->itens;
        if (is_string($rawItens)) {
            $rawItens = json_decode($rawItens, true) ?? [];
        }

        $agrupados = [];
        foreach ($rawItens ?? [] as $item) {
            $itemArr = (array) $item;
            $dia = (int) ($itemArr['dia'] ?? 1);
            $agrupados[$dia][] = $itemArr;
        }

        // Ordenar itens dentro de cada dia
        foreach ($agrupados as &$itens) {
            usort($itens, fn($a, $b) => ((int) ($a['ordem'] ?? 0)) <=> ((int) ($b['ordem'] ?? 0)));
        }

        ksort($agrupados);
        return $agrupados;
    }

    /**
     * Retorna o rótulo do status humanizado.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'rascunho' => '📝 Rascunho',
            'ativo' => '✅ Ativo',
            'concluido' => '🏁 Concluído',
            'arquivado' => '📦 Arquivado',
            default => ucfirst($this->status),
        };
    }
}
