@extends('layouts.app')

@section('title', 'Financeiro')
@section('page_title', 'Financeiro')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Controle Financeiro</div>
        <div class="page-subtitle">Entradas e saídas da paróquia</div>
    </div>
    <a href="{{ route('financas.create') }}" class="btn btn-primary">+ Novo Lançamento</a>
</div>

{{-- Resumo --}}
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card" style="border-left-color:#16a34a;">
        <div class="stat-icon"><i class="fa-solid fa-arrow-trend-up text-green-600"></i></div>
        <div>
            <div class="stat-value" style="color:#16a34a; font-size:20px;">R$ {{ number_format($totalEntradas, 2, ',',
                '.') }}</div>
            <div class="stat-label">Entradas do Mês</div>
        </div>
    </div>
    <div class="stat-card" style="border-left-color:#dc2626;">
        <div class="stat-icon"><i class="fa-solid fa-arrow-trend-down text-red-600"></i></div>
        <div>
            <div class="stat-value" style="color:#dc2626; font-size:20px;">R$ {{ number_format($totalSaidas, 2, ',',
                '.') }}</div>
            <div class="stat-label">Saídas do Mês</div>
        </div>
    </div>
    <div class="stat-card" style="border-left-color:{{ $saldo >= 0 ? '#16a34a' : '#dc2626' }};">
        <div class="stat-icon {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}"><i class="fa-solid fa-wallet"></i>
        </div>
        <div>
            <div class="stat-value" style="color:{{ $saldo >= 0 ? '#16a34a' : '#dc2626' }}; font-size:20px;">
                R$ {{ number_format(abs($saldo), 2, ',', '.') }}
            </div>
            <div class="stat-label">Saldo ({{ $saldo >= 0 ? 'Positivo' : 'Negativo' }})</div>
        </div>
    </div>
</div>

<div class="card">
    <form method="GET" class="search-bar">
        <select name="tipo">
            <option value="">Todos os tipos</option>
            <option value="entrada" {{ request('tipo')=='entrada' ? 'selected' : '' }}>Entradas</option>
            <option value="saida" {{ request('tipo')=='saida' ? 'selected' : '' }}>Saídas</option>
        </select>
        <select name="mes">
            <option value="">Todos os meses</option>
            @for($m = 1; $m <= 12; $m++) <option value="{{ $m }}" {{ request('mes')==$m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
                @endfor
        </select>
        <input type="number" name="ano" placeholder="Ano" value="{{ request('ano', date('Y')) }}" style="width:90px;">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('financas.index') }}" class="btn btn-outline">Limpar</a>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Fiel</th>
                    <th>Forma</th>
                    <th style="text-align:right;">Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($financas as $f)
                <tr>
                    <td style="color:#64748b;">{{ $f->data->format('d/m/Y') }}</td>
                    <td style="font-weight:500;">{{ $f->descricao }}</td>
                    <td>{{ $f->categoria?->nome ?? '—' }}</td>
                    <td>{{ $f->fiel?->nome_completo ?? '—' }}</td>
                    <td>{{ $f->forma_pagamento ?? '—' }}</td>
                    <td
                        style="text-align:right; font-weight:700; color:{{ $f->tipo=='entrada' ? '#16a34a' : '#dc2626' }};">
                        {{ $f->tipo == 'entrada' ? '+' : '-' }} R$ {{ number_format($f->valor, 2, ',', '.') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('financas.edit', $f) }}" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-pen-to-square"></i> Editar</a>
                            <form method="POST" action="{{ route('financas.destroy', $f) }}"
                                onsubmit="window.dispatchEvent(new CustomEvent('confirm-action', { detail: { event: event, message: 'Remover este lançamento?' } }))">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fa-solid fa-trash-can"></i> Remover</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#94a3b8; padding:40px;">Nenhum lançamento
                        encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $financas->links() }}</div>
</div>
@endsection