@extends('layouts.app')

@section('title', 'Sacramento')
@section('page_title', 'Sacramentos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $sacramento->tipo_label }}</div>
        <div class="page-subtitle">{{ $sacramento->fiel->nome_completo }}</div>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('sacramentos.certidao', $sacramento) }}" class="btn btn-success">📄 Baixar Certidão PDF</a>
        <a href="{{ route('sacramentos.edit', $sacramento) }}" class="btn btn-primary">✏️ Editar</a>
        <a href="{{ route('sacramentos.index') }}" class="btn btn-outline">← Voltar</a>
    </div>
</div>

<div class="card">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Fiel</div>
            <div class="detail-value">{{ $sacramento->fiel->nome_completo }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Sacramento</div>
            <div class="detail-value">{{ $sacramento->tipo_label }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Data</div>
            <div class="detail-value">{{ $sacramento->data->format('d/m/Y') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Celebrante</div>
            <div class="detail-value">{{ $sacramento->celebrante ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Local</div>
            <div class="detail-value">{{ $sacramento->local ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Padrinho</div>
            <div class="detail-value">{{ $sacramento->padrinho ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Madrinha</div>
            <div class="detail-value">{{ $sacramento->madrinha ?? '—' }}</div>
        </div>
        @if($sacramento->conjuge)
        <div class="detail-item">
            <div class="detail-label">Cônjuge</div>
            <div class="detail-value">{{ $sacramento->conjuge }}</div>
        </div>
        @endif
        @if($sacramento->testemunha1)
        <div class="detail-item">
            <div class="detail-label">Testemunha 1</div>
            <div class="detail-value">{{ $sacramento->testemunha1 }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Testemunha 2</div>
            <div class="detail-value">{{ $sacramento->testemunha2 ?? '—' }}</div>
        </div>
        @endif
        <div class="detail-item">
            <div class="detail-label">Nº Registro</div>
            <div class="detail-value">{{ $sacramento->numero_registro ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Livro / Folha / Termo</div>
            <div class="detail-value">{{ $sacramento->livro ?? '—' }} / {{ $sacramento->folha ?? '—' }} / {{
                $sacramento->termo ?? '—' }}</div>
        </div>
    </div>
    @if($sacramento->observacoes)
    <div style="margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9;">
        <div class="detail-label">Observações</div>
        <div class="detail-value" style="margin-top:6px;">{{ $sacramento->observacoes }}</div>
    </div>
    @endif
</div>
@endsection