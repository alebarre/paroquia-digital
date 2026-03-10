@extends('layouts.app')

@section('title', 'Grupo')
@section('page_title', 'Grupos e Pastorais')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $grupo->nome }}</div>
        <div class="page-subtitle">{{ $grupo->membrosAtivos->count() }} membro(s) ativo(s)</div>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-primary">✏️ Editar</a>
        <a href="{{ route('grupos.index') }}" class="btn btn-outline">← Voltar</a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
    <div class="card">
        <div class="card-title" style="margin-bottom:16px;">📋 Informações</div>
        <div class="detail-item" style="margin-bottom:12px;">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                @if($grupo->ativo) <span class="badge badge-green">✅ Ativo</span>
                @else <span class="badge badge-gray">⏸ Inativo</span> @endif
            </div>
        </div>
        <div class="detail-item" style="margin-bottom:12px;">
            <div class="detail-label">Coordenador</div>
            <div class="detail-value">{{ $grupo->coordenador?->nome_completo ?? '—' }}</div>
        </div>
        <div class="detail-item" style="margin-bottom:12px;">
            <div class="detail-label">Dia da Reunião</div>
            <div class="detail-value">{{ $grupo->dia_reuniao ?? '—' }}</div>
        </div>
        <div class="detail-item" style="margin-bottom:12px;">
            <div class="detail-label">Horário</div>
            <div class="detail-value">{{ $grupo->hora_reuniao ? substr($grupo->hora_reuniao, 0, 5) : '—' }}</div>
        </div>
        <div class="detail-item" style="margin-bottom:12px;">
            <div class="detail-label">Local</div>
            <div class="detail-value">{{ $grupo->local_reuniao ?? '—' }}</div>
        </div>
        @if($grupo->descricao)
        <div class="detail-item">
            <div class="detail-label">Descrição</div>
            <div class="detail-value" style="margin-top:4px;">{{ $grupo->descricao }}</div>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">👥 Membros Ativos</div>
        </div>
        @forelse($grupo->membrosAtivos as $membro)
        <div
            style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f1f5f9;">
            <div>
                <a href="{{ route('fieis.show', $membro) }}"
                    style="font-weight:600; font-size:14px; color:#2563eb; text-decoration:none;">
                    {{ $membro->nome_completo }}
                </a>
                @if($membro->pivot->data_entrada)
                <div style="font-size:12px; color:#94a3b8;">Desde {{
                    \Carbon\Carbon::parse($membro->pivot->data_entrada)->format('m/Y') }}</div>
                @endif
            </div>
            <span class="badge badge-blue">{{ $membro->pivot->funcao ?? 'Membro' }}</span>
        </div>
        @empty
        <p style="color:#94a3b8; font-size:14px;">Nenhum membro ativo neste grupo.</p>
        @endforelse
    </div>
</div>
@endsection