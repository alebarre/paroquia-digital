<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Evento extends Model
{
    protected $fillable = [
        'titulo', 'tipo', 'data_inicio', 'data_fim',
        'local', 'descricao', 'recorrente', 'recorrencia',
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'recorrente' => 'boolean',
    ];

    public function missa(): HasOne
    {
        return $this->hasOne(Missa::class);
    }
}