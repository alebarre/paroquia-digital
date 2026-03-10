<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Sacramento extends Model
{
    protected $fillable = [
        'fiel_id', 'tipo', 'data', 'celebrante', 'local',
        'padrinho', 'madrinha', 'conjuge', 'testemunha1', 'testemunha2',
        'numero_registro', 'livro', 'folha', 'termo', 'observacoes',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public const TIPOS = [
        'batismo' => 'Batismo',
        'primeira_eucaristia' => 'Primeira Eucaristia',
        'crisma' => 'Crisma',
        'matrimonio' => 'Matrimônio',
        'uncao_enfermos' => 'Unção dos Enfermos',
        'ordenacao' => 'Ordenação',
    ];

    public function fiel(): BelongsTo
    {
        return $this->belongsTo(Fiel::class)->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function getTipoLabelAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }
}