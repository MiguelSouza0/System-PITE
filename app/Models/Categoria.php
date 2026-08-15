<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'slug',
        'icone',
        'descricao',
        'tipo' // atrativo, evento, empreendedor
    ];

    public function atrativos()
    {
        return $this->hasMany(Atrativo::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
