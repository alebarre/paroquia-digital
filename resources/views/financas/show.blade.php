@extends('layouts.app')

@section('title', 'Lançamento')
@section('page_title', 'Financeiro')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $financa->descricao }}</div>
        <div class="page-subtitle">Detalhes do lançamento</div>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('financas.edit', $financa) }}" class="btn btn-primary">✏️ Editar</a>
        <a href="{{ route('financas.index') }}" class="btn btn-outline">← Voltar</a>
    </div>
</div>

<div class="card">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Tipo</div>
            <div class="detail-value">
                @if($financa->tipo == 'entrada')
                <span class="badge badge-green">⬆ Entrada</span>
                @else
                <span class="badge badge-red">⬇ Saída</span>
                @endif
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Valor</div>
            <div class="detail-value"
                style="font-size:20px; font-weight:700; color:{{ $financa->tipo=='entrada' ? '#16a34a' : '#dc2626' }};">
                R$ {{ number_format($financa->valor, 2, ',', '.') }}
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Data</div>
            <div class="detail-value">{{ $financa->data->format('d/m/Y') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Categoria</div>
            <div class="detail-value">{{ $financa->categoria?->nome ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Forma de Pagamento</div>
            <div class="detail-value">{{ $financa->forma_pagamento ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Fiel</div>
            <div class="detail-value">
                @if($financa->fiel)
                <a href="{{ route('fieis.show', $financa->fiel) }}" style="color:#2563eb;">{{
                    $financa->fiel->nome_completo }}</a>
                @else —
                @endif
            </div>
        </div>
    </div>
    @if($financa->observacoes)
    <div style="margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9;">
        <div class="detail-label">Observações</div>
        <div class="detail-value" style="margin-top:6px;">{{ $financa->observacoes }}</div>
    </div>
    @endif
</div>
@endsection