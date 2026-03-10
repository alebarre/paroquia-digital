<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaFinanca extends Model
{
    protected $table = 'categorias_financas';

    protected $fillable = ['nome', 'tipo', 'icone'];

    public function financas(): HasMany
    {
        return $this->hasMany(Financa::class , 'categoria_id');
    }
}