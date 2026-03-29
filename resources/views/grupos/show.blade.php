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
        <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>
            Editar</a>
        <a href="{{ route('grupos.index') }}" class="btn btn-outline">← Voltar</a>
    </div>
</div>

{{-- Mensagens de feedback --}}
@if(session('success'))
<div
    style="background:#dcfce7; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
    ✅ {{ session('success') }}
</div>
@endif
@if($errors->any())
<div
    style="background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
    ⚠️ {{ $errors->first() }}
</div>
@endif

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
    <div class="card">
        <div class="card-title" style="margin-bottom:16px;"><i
                class="fa-solid fa-clipboard-list text-blue-800 mr-2"></i> Informações</div>
        <div class="detail-item" style="margin-bottom:12px;">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                @if($grupo->ativo) <span class="badge badge-green"><i class="fa-solid fa-circle-check"></i> Ativo</span>
                @else <span class="badge badge-gray"><i class="fa-solid fa-circle-pause"></i> Inativo</span> @endif
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
        {{-- Header do card com botão de adicionar --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div class="card-title"><i class="fa-solid fa-users text-blue-900 mr-2"></i> Membros Ativos</div>
            <button onclick="document.getElementById('form-add-membro').classList.toggle('hidden')"
                class="btn btn-primary" style="font-size:13px; padding:6px 14px;">
                + Adicionar Membro
            </button>
        </div>

        {{-- Formulário inline de adicionar membro --}}
        <div id="form-add-membro" class="hidden"
            style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:20px;">
            <form method="POST" action="{{ route('grupos.membros.add', $grupo) }}">
                @csrf
                <div style="display:grid; grid-template-columns:2fr 1fr auto; gap:12px; align-items:end;">
                    <div>
                        <label
                            style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">FIEL</label>
                        <select name="fiel_id" required
                            style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; background:#fff;">
                            <option value="">Selecione um fiel...</option>
                            @foreach($fieis as $fiel)
                            <option value="{{ $fiel->id }}">{{ $fiel->nome_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">FUNÇÃO</label>
                        <input type="text" name="funcao" placeholder="Ex: Coordenador"
                            style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="font-size:13px; padding:8px 16px;">
                        Salvar
                    </button>
                </div>
            </form>
        </div>

        {{-- Lista de membros ativos --}}
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
            <div style="display:flex; align-items:center; gap:10px;">
                <span class="badge badge-blue">{{ $membro->pivot->funcao ?? 'Membro' }}</span>
                <form method="POST" action="{{ route('grupos.membros.remove', [$grupo, $membro]) }}"
                    onsubmit="window.dispatchEvent(new CustomEvent('confirm-action', { detail: { event: event, message: 'Remover {{ addslashes($membro->nome_completo) }} do grupo?' } }))">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:18px; line-height:1; padding:0 2px;"
                        title="Remover membro">✕</button>
                </form>
            </div>
        </div>
        @empty
        <p style="color:#94a3b8; font-size:14px;">Nenhum membro ativo neste grupo.</p>
        @endforelse
    </div>
</div>

<style>
    .hidden {
        display: none !important;
    }
</style>
@endsection