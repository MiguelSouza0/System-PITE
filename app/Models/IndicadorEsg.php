<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorEsg extends Model
{
    use HasFactory;

    protected $table = 'indicadores_esg';

    protected $fillable = [
        'atrativo_id',
        'pilar', // ambiental, social, governanca
        'metrica',
        'valor',
        'unidade_medida',
        'ano_referencia',
        'evidencia_url',
        'status_auditoria' // rascunho, auditado, aprovado
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'ano_referencia' => 'integer'
    ];

    public function atrativo()
    {
        return $this->belongsTo(Atrativo::class);
    }
}
