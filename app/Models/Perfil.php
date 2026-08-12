<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'permissoes'
    ];

    protected $casts = [
        'permissoes' => 'array'
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
