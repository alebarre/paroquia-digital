@extends('layouts.app')

@section('title', 'Avisos')
@section('page_title', 'Avisos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Avisos</div>
        <div class="page-subtitle">Intenções da missa, avisos gerais e outros</div>
    </div>
    <a href="{{ route('avisos.create') }}" class="btn btn-primary">+ Novo Aviso</a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nome do Aviso</th>
                    <th>Tipo de Cadastro</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($avisos as $aviso)
                <tr>
                    <td style="font-weight:600;">{{ $aviso->nomeAviso }}</td>
                    <td>
                        @php
                        $tipos = [
                        1 => ['nome' => 'Intenções da Santa Missa', 'cor' => 'badge-blue'],
                        2 => ['nome' => 'Avisos da Missa', 'cor' => 'badge-purple'],
                        3 => ['nome' => 'Avisos Gerais', 'cor' => 'badge-green'],
                        ];
                        $tipo = $tipos[$aviso->tipoCadastro] ?? ['nome' => 'Desconhecido', 'cor' => 'badge-gray'];
                        @endphp
                        <span class="badge {{ $tipo['cor'] }}">{{ $tipo['nome'] }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($aviso->dataCadastro)->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('avisos.edit', $aviso) }}" class="btn btn-primary btn-sm">✏️</a>
                            <form method="POST" action="{{ route('avisos.destroy', $aviso) }}"
                                onsubmit="window.dispatchEvent(new CustomEvent('confirm-action', { detail: { event: event, message: 'Remover este aviso?' } }))">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#94a3b8; padding:40px;">Nenhum aviso cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $avisos->links() }}</div>
</div>
@endsection