<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';

    protected $fillable = [
        'user_id',
        'favoritavel_id',
        'favoritavel_type',
    ];

    /**
     * Relação polimórfica — pode ser Atrativo ou Evento.
     */
    public function favoritavel(): MorphTo
    {
        return $this->morphTo();
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
