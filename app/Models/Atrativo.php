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
        'descricao',
        'contexto_historico',
        'categoria_id',
        'endereco',
        'bairro',
        'latitude',
        'longitude',
        'horario_funcionamento',
        'formas_acesso',
        'tempo_medio_visita',
        'valor_ingresso',
        'telefone',
        'email',
        'site',
        'acessibilidade_rampa',
        'acessibilidade_elevador',
        'acessibilidade_banheiro',
        'acessibilidade_libras',
        'acessibilidade_piso_tatil',
        'orientacoes_seguranca',
        'restricoes',
        'status', // pendente, aprovado, suspenso
        'destaque'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'valor_ingresso' => 'decimal:2',
        'acessibilidade_rampa' => 'boolean',
        'acessibilidade_elevador' => 'boolean',
        'acessibilidade_banheiro' => 'boolean',
        'acessibilidade_libras' => 'boolean',
        'acessibilidade_piso_tatil' => 'boolean',
        'destaque' => 'boolean'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function midias()
    {
        return $this->hasMany(Midia::class, 'entidade_id')->where('entidade_tipo', 'atrativo');
    }

    public function roteiros()
    {
        return $this->belongsToMany(Roteiro::class, 'roteiro_atrativo')
                    ->withPivot('ordem', 'tempo_estimado_minutos')
                    ->orderBy('pivot_ordem');
    }
}
