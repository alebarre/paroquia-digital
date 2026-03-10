<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'dia_reuniao', 'hora_reuniao',
        'local_reuniao', 'coordenador_id', 'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'hora_reuniao' => 'datetime:H:i',
    ];

    public function coordenador(): BelongsTo
    {
        return $this->belongsTo(Fiel::class , 'coordenador_id');
    }

    public function membros(): BelongsToMany
    {
        return $this->belongsToMany(Fiel::class , 'membros_grupos')
            ->withPivot('funcao', 'data_entrada', 'data_saida', 'ativo')
            ->withTimestamps();
    }

    public function membrosAtivos(): BelongsToMany
    {
        return $this->membros()->wherePivot('ativo', true);
    }
}