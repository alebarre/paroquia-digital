@extends('layouts.app')

@section('title', 'Registrar Sacramento')
@section('page_title', 'Sacramentos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Registrar Sacramento</div>
    </div>
    <a href="{{ route('sacramentos.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('sacramentos.store') }}">
        @csrf

        @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div class="form-grid">
            <div class="form-group">
                <label>Fiel *</label>
                <select name="fiel_id" required>
                    <option value="">— Selecione o fiel —</option>
                    @foreach($fieis as $f)
                    <option value="{{ $f->id }}" {{ (old('fiel_id', $fiel?->id)) == $f->id ? 'selected' : '' }}>
                        {{ $f->nome_completo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tipo de Sacramento *</label>
                <select name="tipo" required>
                    <option value="">— Selecione —</option>
                    @foreach($tipos as $key => $label)
                    <option value="{{ $key }}" {{ old('tipo')==$key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Data *</label>
                <input type="date" name="data" value="{{ old('data') }}" required>
            </div>
            <div class="form-group">
                <label>Celebrante</label>
                <input type="text" name="celebrante" value="{{ old('celebrante') }}" placeholder="Nome do padre">
            </div>
            <div class="form-group">
                <label>Local</label>
                <input type="text" name="local" value="{{ old('local') }}">
            </div>
            <div class="form-group">
                <label>Padrinho</label>
                <input type="text" name="padrinho" value="{{ old('padrinho') }}">
            </div>
            <div class="form-group">
                <label>Madrinha</label>
                <input type="text" name="madrinha" value="{{ old('madrinha') }}">
            </div>
            <div class="form-group">
                <label>Cônjuge (para Matrimônio)</label>
                <input type="text" name="conjuge" value="{{ old('conjuge') }}">
            </div>
            <div class="form-group">
                <label>Testemunha 1</label>
                <input type="text" name="testemunha1" value="{{ old('testemunha1') }}">
            </div>
            <div class="form-group">
                <label>Testemunha 2</label>
                <input type="text" name="testemunha2" value="{{ old('testemunha2') }}">
            </div>
            <div class="form-group">
                <label>Nº do Registro</label>
                <input type="text" name="numero_registro" value="{{ old('numero_registro') }}">
            </div>
            <div class="form-group">
                <label>Livro / Folha / Termo</label>
                <div style="display:flex; gap:8px;">
                    <input type="text" name="livro" placeholder="Livro" value="{{ old('livro') }}" style="flex:1;">
                    <input type="text" name="folha" placeholder="Folha" value="{{ old('folha') }}" style="flex:1;">
                    <input type="text" name="termo" placeholder="Termo" value="{{ old('termo') }}" style="flex:1;">
                </div>
            </div>
            <div class="form-group" style="grid-column:1 / -1;">
                <label>Observações</label>
                <textarea name="observacoes">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cross"></i> Registrar
                Sacramento</button>
            <a href="{{ route('sacramentos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection