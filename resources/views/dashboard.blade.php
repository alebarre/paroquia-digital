@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div>
            <div class="stat-value">{{ $totalFieis }}</div>
            <div class="stat-label">Fiéis Ativos</div>
        </div>
    </div>
    <div class="stat-card" style="border-left-color: #2563eb;">
        <div class="stat-icon">✝️</div>
        <div>
            <div class="stat-value">{{ $sacramentosMes }}</div>
            <div class="stat-label">Sacramentos este mês</div>
        </div>
    </div>
    <div class="stat-card" style="border-left-color: #16a34a;">
        <div class="stat-icon">🤝</div>
        <div>
            <div class="stat-value">{{ $totalGrupos }}</div>
            <div class="stat-label">Grupos Ativos</div>
        </div>
    </div>
    <div class="stat-card" style="border-left-color: {{ $saldo >= 0 ? '#16a34a' : '#dc2626' }};">
        <div class="stat-icon">💰</div>
        <div>
            <div class="stat-value" style="color: {{ $saldo >= 0 ? '#16a34a' : '#dc2626' }}; font-size: 20px;">
                R$ {{ number_format(abs($saldo), 2, ',', '.') }}
            </div>
            <div class="stat-label">Saldo do Mês ({{ $saldo >= 0 ? '+' : '-' }})</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

    {{-- Próximos eventos --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">📅 Próximos Eventos</div>
            <a href="{{ route('eventos.create') }}" class="btn btn-primary btn-sm">+ Novo</a>
        </div>
        @forelse($proximosEventos as $evento)
        <div
            style="display:flex; justify-content:space-between; align-items:center; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
            <div>
                <div style="font-weight:600; font-size:14px;">{{ $evento->titulo }}</div>
                <div style="font-size:12px; color:#64748b;">{{ $evento->data_inicio->format('d/m/Y H:i') }} — {{
                    $evento->local ?? 'Local não definido' }}</div>
            </div>
            <span class="badge badge-blue">{{ $evento->tipo }}</span>
        </div>
        @empty
        <p style="color:#94a3b8; font-size:14px;">Nenhum evento programado.</p>
        @endforelse
    </div>

    {{-- Aniversariantes --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">🎂 Aniversariantes da Semana</div>
        </div>
        @forelse($aniversariantes as $fiel)
        <div
            style="display:flex; justify-content:space-between; align-items:center; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
            <div>
                <div style="font-weight:600; font-size:14px;">{{ $fiel->nome_completo }}</div>
                <div style="font-size:12px; color:#64748b;">{{ $fiel->data_nascimento->format('d/m') }} • {{
                    $fiel->idade }} anos</div>
            </div>
            <a href="{{ route('fieis.show', $fiel) }}" class="btn btn-outline btn-sm">Ver</a>
        </div>
        @empty
        <p style="color:#94a3b8; font-size:14px;">Nenhum aniversariante esta semana. 🎉</p>
        @endforelse
    </div>

    {{-- Financeiro do mês --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">💰 Financeiro — {{ now()->translatedFormat('F Y') }}</div>
            <a href="{{ route('financas.index') }}" class="btn btn-outline btn-sm">Ver tudo</a>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:8px;">
            <div style="text-align:center; padding:16px; background:#f0fdf4; border-radius:10px;">
                <div style="font-size:20px; font-weight:700; color:#16a34a;">R$ {{ number_format($totalEntradas, 2, ',',
                    '.') }}</div>
                <div style="font-size:12px; color:#166534; margin-top:4px;">⬆ Entradas</div>
            </div>
            <div style="text-align:center; padding:16px; background:#fef2f2; border-radius:10px;">
                <div style="font-size:20px; font-weight:700; color:#dc2626;">R$ {{ number_format($totalSaidas, 2, ',',
                    '.') }}</div>
                <div style="font-size:12px; color:#991b1b; margin-top:4px;">⬇ Saídas</div>
            </div>
        </div>
        <a href="{{ route('financas.create') }}" class="btn btn-primary"
            style="margin-top:16px; width:100%; justify-content:center;">+ Registrar Lançamento</a>
    </div>

    {{-- Sacramentos por tipo --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">✝️ Sacramentos por Tipo</div>
            <a href="{{ route('sacramentos.index') }}" class="btn btn-outline btn-sm">Ver tudo</a>
        </div>
        @php $tipos = App\Models\Sacramento::TIPOS; @endphp
        @foreach($tipos as $key => $label)
        @php $total = $sacramentosPorTipo->get($key, 0); @endphp
        <div
            style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f1f5f9; font-size:14px;">
            <span>{{ $label }}</span>
            <span style="font-weight:600; color: #1a3a5c;">{{ $total }}</span>
        </div>
        @endforeach
        <a href="{{ route('sacramentos.create') }}" class="btn btn-accent"
            style="margin-top:16px; width:100%; justify-content:center;">+ Registrar Sacramento</a>
    </div>
</div>
@endsection