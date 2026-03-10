@extends('layouts.app')

@section('title', 'Editar Lançamento')
@section('page_title', 'Financeiro')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Editar Lançamento</div>
    </div>
    <a href="{{ route('financas.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('financas.update', $financa) }}">
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
                <label>Tipo *</label>
                <select name="tipo" required>
                    <option value="entrada" {{ old('tipo', $financa->tipo) == 'entrada' ? 'selected' : '' }}>⬆ Entrada
                    </option>
                    <option value="saida" {{ old('tipo', $financa->tipo) == 'saida' ? 'selected' : '' }}>⬇ Saída
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Categoria</label>
                <select name="categoria_id">
                    <option value="">— Nenhuma —</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id', $financa->categoria_id) == $cat->id ?
                        'selected' : '' }}>
                        {{ $cat->nome }} ({{ $cat->tipo }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição *</label>
                <input type="text" name="descricao" value="{{ old('descricao', $financa->descricao) }}" required>
            </div>
            <div class="form-group">
                <label>Valor (R$) *</label>
                <input type="number" name="valor" value="{{ old('valor', $financa->valor) }}" step="0.01" min="0.01"
                    required>
            </div>
            <div class="form-group">
                <label>Data *</label>
                <input type="date" name="data" value="{{ old('data', $financa->data->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Forma de Pagamento</label>
                <select name="forma_pagamento">
                    <option value="">— Selecione —</option>
                    @foreach(['dinheiro'=>'💵 Dinheiro','pix'=>'📱 PIX','transferencia'=>'🏦
                    Transferência','cheque'=>'📄 Cheque'] as $val => $lbl)
                    <option value="{{ $val }}" {{ old('forma_pagamento', $financa->forma_pagamento) == $val ? 'selected'
                        : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Fiel Relacionado</label>
                <select name="fiel_id">
                    <option value="">— Nenhum —</option>
                    @foreach($fieis as $f)
                    <option value="{{ $f->id }}" {{ old('fiel_id', $financa->fiel_id) == $f->id ? 'selected' : '' }}>{{
                        $f->nome_completo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Observações</label>
                <textarea name="observacoes">{{ old('observacoes', $financa->observacoes) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
            <a href="{{ route('financas.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection