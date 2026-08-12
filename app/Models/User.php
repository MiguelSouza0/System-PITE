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
        'ativo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ativo' => 'boolean'
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

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
}
