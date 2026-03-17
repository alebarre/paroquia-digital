@extends('layouts.app')

@section('title', 'Usuários')
@section('page_title', 'Administração')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">👤 Usuários do Sistema</div>
        <div class="page-subtitle">{{ $usuarios->count() }} usuário(s) cadastrado(s)</div>
    </div>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Novo Usuário</a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil (Role)</th>
                    <th>Cadastrado em</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td>
                        <div style="font-weight:600;">{{ $usuario->name }}</div>
                        @if($usuario->id === Auth::id())
                        <div style="font-size:11px; color:#94a3b8;">(você)</div>
                        @endif
                    </td>
                    <td style="color:#64748b;">{{ $usuario->email }}</td>
                    <td>
                        @foreach($usuario->roles as $role)
                        @php
                        $badgeClass = match($role->name) {
                        'admin' => 'badge-red',
                        'secretaria' => 'badge-blue',
                        'padre' => 'badge-purple',
                        default => 'badge-gray',
                        };
                        $label = match($role->name) {
                        'admin' => '🔑 Admin',
                        'secretaria' => '📋 Secretaria',
                        'padre' => '✝️ Padre',
                        default => $role->name,
                        };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                        @endforeach
                    </td>
                    <td style="color:#64748b; font-size:13px;">
                        {{ $usuario->created_at->format('d/m/Y') }}
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            @unless($usuario->hasRole('admin'))
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-outline btn-sm">✏️
                                Editar</a>
                            @if($usuario->id !== Auth::id())
                            <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                onsubmit="window.dispatchEvent(new CustomEvent('confirm-action', { detail: { event: event, message: 'Excluir {{ addslashes($usuario->name) }}?' } }))">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Excluir</button>
                            </form>
                            @endif
                            @else
                            <span style="font-size:12px; color:#94a3b8;">— conta protegida</span>
                            @endunless
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#94a3b8; padding:32px;">
                        Nenhum usuário cadastrado ainda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection