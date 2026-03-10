<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Familia extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'bairro', 'endereco', 'telefone'];

    public function fieis(): HasMany
    {
        return $this->hasMany(Fiel::class);
    }
}