<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiConversa extends Model
{
    use HasFactory;

    protected $table = 'ai_conversas';

    protected $fillable = [
        'user_id',
        'sessao_id',
        'remetente',
        'mensagem',
        'dados_extras',
        'idioma',
    ];

    protected $casts = [
        'dados_extras' => 'array',
    ];

    // --- Relacionamentos ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --- Scopes ---

    public function scopeDaSessao($query, string $sessaoId)
    {
        return $query->where('sessao_id', $sessaoId);
    }

    public function scopeDoUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
