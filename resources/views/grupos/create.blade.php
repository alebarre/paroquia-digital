@extends('layouts.app')

@section('title', 'Novo Grupo')
@section('page_title', 'Grupos e Pastorais')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Novo Grupo ou Pastoral</div>
    </div>
    <a href="{{ route('grupos.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('grupos.store') }}">
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
                <label>Nome do Grupo *</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required
                    placeholder="Ex: Pastoral da Juventude, Grupo de Oração...">
            </div>
            <div class="form-group">
                <label>Coordenador</label>
                <select name="coordenador_id">
                    <option value="">— Nenhum —</option>
                    @foreach($fieis as $fiel)
                    <option value="{{ $fiel->id }}" {{ old('coordenador_id')==$fiel->id ? 'selected' : '' }}>
                        {{ $fiel->nome_completo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Dia da Reunião</label>
                <select name="dia_reuniao">
                    <option value="">— Selecione —</option>
                    @foreach(['Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado','Domingo']
                    as $dia)
                    <option value="{{ $dia }}" {{ old('dia_reuniao')==$dia ? 'selected' : '' }}>{{ $dia }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Horário da Reunião</label>
                <input type="time" name="hora_reuniao" value="{{ old('hora_reuniao') }}">
            </div>
            <div class="form-group">
                <label>Local da Reunião</label>
                <input type="text" name="local_reuniao" value="{{ old('local_reuniao') }}"
                    placeholder="Ex: Salão Paroquial">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="ativo">
                    <option value="1" {{ old('ativo', '1' )=='1' ? 'selected' : '' }}>✅ Ativo</option>
                    <option value="0" {{ old('ativo')=='0' ? 'selected' : '' }}>⏸ Inativo</option>
                </select>
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição</label>
                <textarea name="descricao"
                    placeholder="Objetivo e atividades do grupo...">{{ old('descricao') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">🤝 Salvar Grupo</button>
            <a href="{{ route('grupos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection