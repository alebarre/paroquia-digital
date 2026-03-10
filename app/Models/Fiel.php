<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fiel extends Model
{
    use SoftDeletes;

    protected $table = 'fieis';

    protected $fillable = [
        'familia_id', 'nome', 'sobrenome', 'cpf', 'data_nascimento',
        'sexo', 'estado_civil', 'telefone', 'email', 'endereco',
        'bairro', 'cidade', 'cep', 'foto', 'status', 'observacoes',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function getNomeCompletoAttribute(): string
    {
        return "{$this->nome} {$this->sobrenome}";
    }

    public function getIdadeAttribute(): ?int
    {
        return $this->data_nascimento?->age;
    }

    public function familia(): BelongsTo
    {
        return $this->belongsTo(Familia::class);
    }

    public function sacramentos(): HasMany
    {
        return $this->hasMany(Sacramento::class);
    }

    public function grupos(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'membros_grupos')
            ->withPivot('funcao', 'data_entrada', 'data_saida', 'ativo')
            ->withTimestamps();
    }

    public function financas(): HasMany
    {
        return $this->hasMany(Financa::class);
    }

    public function scopeAniversariantesDaSemana($query)
    {
        $hoje = now()->dayOfYear;
        $fimSemana = now()->addDays(7)->dayOfYear;
        return $query->whereRaw("dayofyear(data_nascimento) BETWEEN ? AND ?", [$hoje, $fimSemana]);
    }
}