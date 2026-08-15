<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoVisita extends Model
{
    use HasFactory;

    protected $table = 'historico_visitas';

    protected $fillable = [
        'user_id',
        'atrativo_id',
        'visitado_em',
        'tempo_permanencia_min',
        'notas_pessoais',
    ];

    protected $casts = [
        'visitado_em' => 'date',
        'tempo_permanencia_min' => 'integer',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function atrativo(): BelongsTo
    {
        return $this->belongsTo(Atrativo::class);
    }
}
