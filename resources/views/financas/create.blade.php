@extends('layouts.app')

@section('title', 'Novo Lançamento')
@section('page_title', 'Financeiro')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Novo Lançamento</div>
    </div>
    <a href="{{ route('financas.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('financas.store') }}">
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
                <label>Tipo *</label>
                <select name="tipo" required>
                    <option value="">— Selecione —</option>
                    <option value="entrada" {{ old('tipo')=='entrada' ? 'selected' : '' }}>⬆ Entrada</option>
                    <option value="saida" {{ old('tipo')=='saida' ? 'selected' : '' }}>⬇ Saída</option>
                </select>
            </div>
            <div class="form-group">
                <label>Categoria</label>
                <select name="categoria_id">
                    <option value="">— Nenhuma —</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id')==$cat->id ? 'selected' : '' }}>
                        {{ $cat->nome }} ({{ $cat->tipo }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição *</label>
                <input type="text" name="descricao" value="{{ old('descricao') }}" required
                    placeholder="Ex: Dízimo de João Silva">
            </div>
            <div class="form-group">
                <label>Valor (R$) *</label>
                <input type="number" name="valor" value="{{ old('valor') }}" step="0.01" min="0.01" required
                    placeholder="0,00">
            </div>
            <div class="form-group">
                <label>Data *</label>
                <input type="date" name="data" value="{{ old('data', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Forma de Pagamento</label>
                <select name="forma_pagamento">
                    <option value="">— Selecione —</option>
                    <option value="dinheiro" {{ old('forma_pagamento')=='dinheiro' ? 'selected' : '' }}>💵 Dinheiro
                    </option>
                    <option value="pix" {{ old('forma_pagamento')=='pix' ? 'selected' : '' }}>📱 PIX</option>
                    <option value="transferencia" {{ old('forma_pagamento')=='transferencia' ? 'selected' :'' }}>🏦
                        Transferência</option>
                    <option value="cheque" {{ old('forma_pagamento')=='cheque' ? 'selected' : '' }}>Cheque</option>
                </select>
            </div>
            <div class="form-group">
                <label>Fiel Relacionado</label>
                <select name="fiel_id">
                    <option value="">— Nenhum —</option>
                    @foreach($fieis as $f)
                    <option value="{{ $f->id }}" {{ old('fiel_id')==$f->id ? 'selected' : '' }}>{{ $f->nome_completo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Observações</label>
                <textarea name="observacoes">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar
                Lançamento</button>
            <a href="{{ route('financas.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection