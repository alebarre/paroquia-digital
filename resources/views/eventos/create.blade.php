@extends('layouts.app')

@section('title', 'Novo Evento')
@section('page_title', 'Eventos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Novo Evento</div>
        <div class="page-subtitle">Cadastre missas, retiros, novenas e outros eventos</div>
    </div>
    <a href="{{ route('eventos.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('eventos.store') }}">
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
                <label>Título *</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" required
                    placeholder="Ex: Missa de Domingo, Retiro de Quaresma...">
            </div>
            <div class="form-group">
                <label>Tipo *</label>
                <select name="tipo" required>
                    <option value="">— Selecione —</option>
                    <option value="missa" {{ old('tipo')=='missa' ? 'selected' :'' }}>⛪ Missa</option>
                    <option value="retiro" {{ old('tipo')=='retiro' ? 'selected' :'' }}>🏕️ Retiro</option>
                    <option value="novena" {{ old('tipo')=='novena' ? 'selected' :'' }}>🕯️ Novena</option>
                    <option value="quermesse" {{ old('tipo')=='quermesse' ? 'selected' :'' }}>🎪 Quermesse</option>
                    <option value="reuniao" {{ old('tipo')=='reuniao' ? 'selected' :'' }}>👥 Reunião</option>
                    <option value="outro" {{ old('tipo')=='outro' ? 'selected' :'' }}>📌 Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label>Local</label>
                <input type="text" name="local" value="{{ old('local') }}"
                    placeholder="Ex: Igreja Principal, Salão Paroquial...">
            </div>
            <div class="form-group">
                <label>Data e Hora de Início *</label>
                <input type="datetime-local" name="data_inicio" value="{{ old('data_inicio') }}" required>
            </div>
            <div class="form-group">
                <label>Data e Hora de Fim</label>
                <input type="datetime-local" name="data_fim" value="{{ old('data_fim') }}">
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição</label>
                <textarea name="descricao" placeholder="Detalhes do evento...">{{ old('descricao') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">📅 Salvar Evento</button>
            <a href="{{ route('eventos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection