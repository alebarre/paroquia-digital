<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Missa extends Model
{
    protected $fillable = [
        'evento_id', 'celebrante', 'leitores', 'ministros',
        'coroinha', 'cantor', 'intencoes', 'observacoes',
    ];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}