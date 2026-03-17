@extends('layouts.app')

@section('title', 'Fiéis')
@section('page_title', 'Fiéis')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Cadastro de Fiéis</div>
        <div class="page-subtitle">Gerencie os paroquianos cadastrados</div>
    </div>
    <a href="{{ route('fieis.create') }}" class="btn btn-primary">+ Novo Fiel</a>
</div>

<div class="card">
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="🔍 Buscar por nome, CPF ou e-mail..."
            value="{{ request('search') }}" style="min-width:280px;">
        <select name="status">
            <option value="">Todos os status</option>
            <option value="ativo" {{ request('status')=='ativo' ? 'selected' : '' }}>✅ Ativo</option>
            <option value="inativo" {{ request('status')=='inativo' ? 'selected' : '' }}>⏸ Inativo</option>
            <option value="falecido" {{ request('status')=='falecido' ? 'selected' : '' }}>🕊 Falecido</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('fieis.index') }}" class="btn btn-outline">Limpar</a>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Bairro</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fieis as $fiel)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $fiel->id }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $fiel->nome_completo }}</div>
                        @if($fiel->data_nascimento)
                        <div style="font-size:12px; color:#94a3b8;">{{ $fiel->data_nascimento->format('d/m/Y') }} ({{
                            $fiel->idade }} anos)</div>
                        @endif
                    </td>
                    <td>{{ $fiel->telefone ?? '—' }}</td>
                    <td>{{ $fiel->email ?? '—' }}</td>
                    <td>{{ $fiel->bairro ?? '—' }}</td>
                    <td>
                        @if($fiel->status === 'ativo')
                        <span class="badge badge-green">✅ Ativo</span>
                        @elseif($fiel->status === 'inativo')
                        <span class="badge badge-gray">⏸ Inativo</span>
                        @else
                        <span class="badge badge-gray">🕊 Falecido</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('fieis.show', $fiel) }}" class="btn btn-outline btn-sm">Ver</a>
                            <a href="{{ route('fieis.edit', $fiel) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form method="POST" action="{{ route('fieis.destroy', $fiel) }}"
                                onsubmit="window.dispatchEvent(new CustomEvent('confirm-action', { detail: { event: event, message: 'Remover este fiel?' } }))">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#94a3b8; padding:40px;">
                        Nenhum fiel encontrado.
                        <a href="{{ route('fieis.create') }}" style="color:#2563eb;">Cadastrar agora</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $fieis->links() }}</div>
</div>
@endsection