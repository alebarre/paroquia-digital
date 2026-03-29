@extends('layouts.app')

@section('title', 'Novo Usuário')
@section('page_title', 'Administração')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title"><i class="fa-solid fa-user-plus"></i> Novo Usuário</div>
        <div class="page-subtitle">Cadastrar usuário com perfil secretaria ou padre</div>
    </div>
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card" style="max-width:640px;">
    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div class="form-grid">
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="name">Nome completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Ex: Maria das Graças">
                @error('name')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="usuario@paroquia.local">
                @error('email')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input id="password" type="password" name="password" required placeholder="Mínimo 6 caracteres">
                @error('password')
                <span style="color:#dc2626; font-size:12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="Repita a senha">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="role">Perfil de acesso</label>
                <select id="role" name="role" required>
                    <option value="">Selecione um perfil...</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role')===$role->name ? 'selected' : '' }}>
                        {{ match($role->name) {
                        'secretaria' => 'Secretaria — gerencia fiéis, sacramentos e eventos',
                        'padre' => 'Padre — visualização geral e sacramentos',
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
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-user-check"></i> Criar Usuário</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection