<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'atrativo_id',
        'user_id',
        'nota',
        'comentario',
        'visitado_em',
        'comprovante_visita_path',
        'status_verificacao', // pendente, verificado, rejeitado
        'origem_turista' // local, nacional, internacional
    ];

    protected $casts = [
        'visitado_em' => 'date',
        'nota' => 'integer'
    ];

    public function atrativo()
    {
        return $this->belongsTo(Atrativo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
