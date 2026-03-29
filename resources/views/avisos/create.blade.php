@extends('layouts.app')

@section('title', 'Novo Aviso')
@section('page_title', 'Avisos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Novo Aviso</div>
        <div class="page-subtitle">Cadastre um novo aviso ou intenção</div>
    </div>
    <a href="{{ route('avisos.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('avisos.store') }}">
        @csrf

        @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div class="form-grid">
            <div class="form-group" style="grid-column:span 2;">
                <label>Nome do Aviso *</label>
                <input type="text" name="nomeAviso" value="{{ old('nomeAviso') }}" required
                    placeholder="Ex: Confissões comunitárias, Terço dos homens...">
            </div>

            <div class="form-group">
                <label>Tipo de Cadastro *</label>
                <select name="tipoCadastro" id="tipoCadastro" required>
                    <option value="">— Selecione —</option>
                    <option value="1" {{ old('tipoCadastro')=='1' ? 'selected' : '' }}>1 - Intenções da santa missa
                    </option>
                    <option value="2" {{ old('tipoCadastro')=='2' ? 'selected' : '' }}>2 - Avisos da missa</option>
                    <option value="3" {{ old('tipoCadastro')=='3' ? 'selected' : '' }}>3 - Avisos gerais
                        (Email/WhatsApp)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Data de Cadastro *</label>
                <input type="date" name="dataCadastro" value="{{ old('dataCadastro', date('Y-m-d')) }}" required>
            </div>

            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição</label>
                <textarea name="descricaoAviso"
                    placeholder="Detalhes do aviso ou intenções...">{{ old('descricaoAviso') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-bullhorn"></i> Salvar Aviso</button>
            <a href="{{ route('avisos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection