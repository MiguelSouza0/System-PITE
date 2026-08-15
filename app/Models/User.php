<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'perfil_id',
        'ativo',
        'nacionalidade',
        'cep',
        'cidade_origem',
        'estado_origem',
        'pais_origem',
        'possui_conjuge',
        'possui_filhos',
        'quantidade_filhos',
        'interesses',
        'necessidades_especiais',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ativo' => 'boolean',
        'possui_conjuge' => 'boolean',
        'possui_filhos' => 'boolean',
        'quantidade_filhos' => 'integer',
        'interesses' => 'array',
        'necessidades_especiais' => 'array',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    // --- Relações do Turista ---

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function historicoVisitas()
    {
        return $this->hasMany(HistoricoVisita::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    // --- Verificações de Perfil ---

    public function isPrefeito()
    {
        return $this->perfil && $this->perfil->slug === 'prefeito';
    }

    public function isSecretario()
    {
        return $this->perfil && $this->perfil->slug === 'secretario';
    }

    public function isAdmin()
    {
        return $this->perfil && in_array($this->perfil->slug, ['admin', 'prefeito', 'secretario', 'servidor']);
    }

    public function isEmpreendedor()
    {
        return $this->perfil && $this->perfil->slug === 'empreendedor';
    }

    public function isTurista()
    {
        return $this->perfil && $this->perfil->slug === 'turista';
    }

    // --- Helpers do Turista ---

    /**
     * Retorna os nomes formatados dos interesses do turista.
     */
    public function interessesFormatados(): array
    {
        $mapa = [
            'natureza' => '🌿 Natureza & Ecoturismo',
            'historia' => '🏛️ História & Patrimônio',
            'gastronomia' => '🍽️ Gastronomia',
            'aventura' => '🧗 Aventura & Esporte',
            'cultural' => '🎭 Cultural & Artístico',
            'religioso' => '⛪ Religioso',
            'rural' => '🌾 Rural & Agroturismo',
            'negocios' => '💼 Negócios & Eventos',
            'saude' => '💆 Saúde & Bem-estar',
            'nautico' => '⛵ Náutico',
            'compras' => '🛍️ Compras & Artesanato',
            'familia' => '👨‍👩‍👧‍👦 Família & Lazer',
        ];

        return collect($this->interesses ?? [])
            ->map(fn($i) => $mapa[$i] ?? ucfirst($i))
            ->toArray();
    }

    /**
     * Verifica se o turista favoritou um item específico.
     */
    public function favoritou($model): bool
    {
        return $this->favoritos()
            ->where('favoritavel_id', $model->id)
            ->where('favoritavel_type', get_class($model))
            ->exists();
    }

    /**
     * Verifica se o turista já visitou um atrativo específico.
     */
    public function jaVisitou(Atrativo $atrativo): bool
    {
        return $this->historicoVisitas()
            ->where('atrativo_id', $atrativo->id)
            ->exists();
    }
}
