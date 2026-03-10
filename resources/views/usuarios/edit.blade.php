@extends('layouts.app')

@section('title', 'Editar Usuário')
@section('page_title', 'Administração')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">✏️ Editar Usuário</div>
        <div class="page-subtitle">{{ $usuario->name }}</div>
    </div>
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card" style="max-width:640px;">
    <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="name">Nome completo</label>
                <input id="name" type="text" name="name" value="{{ old('name', $usuario->name) }}" required autofocus>
                @error('name')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nova senha <span style="color:#94a3b8; font-weight:400;">(deixe em branco para não
                        alterar)</span></label>
                <input id="password" type="password" name="password" placeholder="Mínimo 6 caracteres">
                @error('password')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar nova senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Repita a nova senha">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="role">Perfil de acesso</label>
                <select id="role" name="role" required>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ ($usuario->hasRole($role->name) || old('role') === $role->name)
                        ? 'selected' : '' }}>
                        {{ match($role->name) {
                        'secretaria' => '📋 Secretaria — gerencia fiéis, sacramentos e eventos',
                        'padre' => '✝️ Padre — visualização geral e sacramentos',
                        default => ucfirst($role->name),
                        } }}
                    </option>
                    @endforeach
                </select>
                @error('role')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection