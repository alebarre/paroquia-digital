<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Financa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'categoria_id', 'fiel_id', 'descricao', 'tipo',
        'valor', 'data', 'forma_pagamento', 'comprovante', 'observacoes',
    ];

    protected $casts = [
        'data' => 'date',
        'valor' => 'decimal:2',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaFinanca::class , 'categoria_id');
    }

    public function fiel(): BelongsTo
    {
        return $this->belongsTo(Fiel::class);
    }

    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    public function scopeSaidas($query)
    {
        return $query->where('tipo', 'saida');
    }
}