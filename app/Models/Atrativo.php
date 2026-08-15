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
        'horario_funcionamento',
        'preco_medio',
        'niveis_acessibilidade',
        'caracteristicas_esg',
        'destaque',
        'ativo'
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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
}
