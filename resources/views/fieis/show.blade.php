@extends('layouts.app')

@section('title', $fiel->nome_completo)
@section('page_title', 'Fiéis')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $fiel->nome_completo }}</div>
        <div class="page-subtitle">Detalhes do fiel</div>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('fieis.edit', $fiel) }}" class="btn btn-primary">✏️ Editar</a>
        <a href="{{ route('sacramentos.create', ['fiel_id' => $fiel->id]) }}" class="btn btn-accent">✝️ + Sacramento</a>
        <a href="{{ route('fieis.index') }}" class="btn btn-outline">← Voltar</a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
    <div>
        <div class="card" style="text-align:center;">
            @if($fiel->foto)
            <img src="{{ Storage::url($fiel->foto) }}" alt="Foto"
                style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:16px;">
            @else
            <div style="width:120px; height:120px; border-radius:50%; background:#e2e8f0;
                     display:flex; align-items:center; justify-content:center;
                     font-size:48px; margin:0 auto 16px; color:#94a3b8;">👤</div>
            @endif
            <div style="font-size:18px; font-weight:700; color:#1a3a5c;">{{ $fiel->nome_completo }}</div>
            @if($fiel->data_nascimento)
            <div style="color:#64748b; font-size:14px; margin-top:4px;">{{ $fiel->data_nascimento->format('d/m/Y') }}
                ({{ $fiel->idade }} anos)</div>
            @endif
            <div style="margin-top:12px;">
                @if($fiel->status === 'ativo') <span class="badge badge-green">✅ Ativo</span>
                @elseif($fiel->status === 'inativo') <span class="badge badge-gray">⏸ Inativo</span>
                @else <span class="badge badge-gray">🕊 Falecido</span> @endif
            </div>
        </div>

        <div class="card">
            <div class="card-title" style="margin-bottom:16px;">📞 Contato</div>
            <div class="detail-item" style="margin-bottom:12px;">
                <div class="detail-label">Telefone</div>
                <div class="detail-value">{{ $fiel->telefone ?? '—' }}</div>
            </div>
            <div class="detail-item" style="margin-bottom:12px;">
                <div class="detail-label">E-mail</div>
                <div class="detail-value">{{ $fiel->email ?? '—' }}</div>
            </div>
            <div class="detail-item" style="margin-bottom:12px;">
                <div class="detail-label">Endereço</div>
                <div class="detail-value">{{ $fiel->endereco ?? '—' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Bairro / Cidade</div>
                <div class="detail-value">{{ $fiel->bairro ?? '—' }}{{ $fiel->cidade ? ' / '.$fiel->cidade : '' }}</div>
            </div>
        </div>
    </div>

    <div>
        {{-- Sacramentos --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">✝️ Sacramentos</div>
                <a href="{{ route('sacramentos.create', ['fiel_id' => $fiel->id]) }}" class="btn btn-primary btn-sm">+
                    Registrar</a>
            </div>
            @forelse($fiel->sacramentos as $sac)
            <div
                style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #f1f5f9;">
                <div>
                    <div style="font-weight:600; font-size:14px;">{{ $sac->tipo_label }}</div>
                    <div style="font-size:12px; color:#94a3b8;">{{ $sac->data->format('d/m/Y') }}{{ $sac->celebrante ? '
                        — '.$sac->celebrante : '' }}</div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="{{ route('sacramentos.show', $sac) }}" class="btn btn-outline btn-sm">Ver</a>
                    <a href="{{ route('sacramentos.certidao', $sac) }}" class="btn btn-success btn-sm">📄 PDF</a>
                </div>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:14px;">Nenhum sacramento registrado.</p>
            @endforelse
        </div>

        {{-- Grupos --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">🤝 Grupos e Pastorais</div>
            </div>
            @forelse($fiel->grupos as $grupo)
            <div
                style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:14px;">
                <span style="font-weight:600;">{{ $grupo->nome }}</span>
                <span class="badge badge-blue">{{ $grupo->pivot->funcao ?? 'Membro' }}</span>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:14px;">Não participa de nenhum grupo.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection