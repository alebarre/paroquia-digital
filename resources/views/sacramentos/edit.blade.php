@extends('layouts.app')

@section('title', 'Editar Sacramento')
@section('page_title', 'Sacramentos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Editar Sacramento</div>
    </div>
    <a href="{{ route('sacramentos.show', $sacramento) }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('sacramentos.update', $sacramento) }}">
        @csrf @method('PATCH')

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
                    @foreach($fieis as $f)
                    <option value="{{ $f->id }}" {{ old('fiel_id', $sacramento->fiel_id) == $f->id ? 'selected' : '' }}>
                        {{ $f->nome_completo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tipo *</label>
                <select name="tipo" required>
                    @foreach($tipos as $key => $label)
                    <option value="{{ $key }}" {{ old('tipo', $sacramento->tipo) == $key ? 'selected' : '' }}>{{ $label
                        }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Data *</label>
                <input type="date" name="data" value="{{ old('data', $sacramento->data->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Celebrante</label>
                <input type="text" name="celebrante" value="{{ old('celebrante', $sacramento->celebrante) }}">
            </div>
            <div class="form-group">
                <label>Local</label>
                <input type="text" name="local" value="{{ old('local', $sacramento->local) }}">
            </div>
            <div class="form-group">
                <label>Padrinho</label>
                <input type="text" name="padrinho" value="{{ old('padrinho', $sacramento->padrinho) }}">
            </div>
            <div class="form-group">
                <label>Madrinha</label>
                <input type="text" name="madrinha" value="{{ old('madrinha', $sacramento->madrinha) }}">
            </div>
            <div class="form-group">
                <label>Cônjuge</label>
                <input type="text" name="conjuge" value="{{ old('conjuge', $sacramento->conjuge) }}">
            </div>
            <div class="form-group">
                <label>Testemunha 1</label>
                <input type="text" name="testemunha1" value="{{ old('testemunha1', $sacramento->testemunha1) }}">
            </div>
            <div class="form-group">
                <label>Testemunha 2</label>
                <input type="text" name="testemunha2" value="{{ old('testemunha2', $sacramento->testemunha2) }}">
            </div>
            <div class="form-group">
                <label>Nº Registro</label>
                <input type="text" name="numero_registro"
                    value="{{ old('numero_registro', $sacramento->numero_registro) }}">
            </div>
            <div class="form-group">
                <label>Livro / Folha / Termo</label>
                <div style="display:flex; gap:8px;">
                    <input type="text" name="livro" placeholder="Livro" value="{{ old('livro', $sacramento->livro) }}"
                        style="flex:1;">
                    <input type="text" name="folha" placeholder="Folha" value="{{ old('folha', $sacramento->folha) }}"
                        style="flex:1;">
                    <input type="text" name="termo" placeholder="Termo" value="{{ old('termo', $sacramento->termo) }}"
                        style="flex:1;">
                </div>
            </div>
            <div class="form-group" style="grid-column:1 / -1;">
                <label>Observações</label>
                <textarea name="observacoes">{{ old('observacoes', $sacramento->observacoes) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
            <a href="{{ route('sacramentos.show', $sacramento) }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection