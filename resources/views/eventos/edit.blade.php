@extends('layouts.app')

@section('title', 'Editar Evento')
@section('page_title', 'Eventos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Editar: {{ $evento->titulo }}</div>
    </div>
    <a href="{{ route('eventos.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('eventos.update', $evento) }}">
        @csrf @method('PATCH')

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
                <input type="text" name="titulo" value="{{ old('titulo', $evento->titulo) }}" required>
            </div>
            <div class="form-group">
                <label>Tipo *</label>
                <select name="tipo" required>
                    @foreach(['missa'=>'Missa','retiro'=>'Retiro','novena'=>'Novena','quermesse'=>'Quermesse','reuniao'=>'Reunião','outro'=>'Outro']
                    as $val => $lbl)
                    <option value="{{ $val }}" {{ old('tipo', $evento->tipo) == $val ? 'selected' : '' }}>{{ $lbl }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Local</label>
                <input type="text" name="local" value="{{ old('local', $evento->local) }}">
            </div>
            <div class="form-group">
                <label>Data e Hora de Início *</label>
                <input type="datetime-local" name="data_inicio"
                    value="{{ old('data_inicio', $evento->data_inicio->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label>Data e Hora de Fim</label>
                <input type="datetime-local" name="data_fim"
                    value="{{ old('data_fim', $evento->data_fim?->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição</label>
                <textarea name="descricao">{{ old('descricao', $evento->descricao) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-calendar-check"></i> Salvar
                Alterações</button>
            <a href="{{ route('eventos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection