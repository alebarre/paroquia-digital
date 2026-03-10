@extends('layouts.app')

@section('title', 'Editar Grupo')
@section('page_title', 'Grupos e Pastorais')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Editar: {{ $grupo->nome }}</div>
    </div>
    <a href="{{ route('grupos.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('grupos.update', $grupo) }}">
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
                <label>Nome do Grupo *</label>
                <input type="text" name="nome" value="{{ old('nome', $grupo->nome) }}" required>
            </div>
            <div class="form-group">
                <label>Coordenador</label>
                <select name="coordenador_id">
                    <option value="">— Nenhum —</option>
                    @foreach($fieis as $fiel)
                    <option value="{{ $fiel->id }}" {{ old('coordenador_id', $grupo->coordenador_id) == $fiel->id ?
                        'selected' : '' }}>
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
                    <option value="{{ $dia }}" {{ old('dia_reuniao', $grupo->dia_reuniao) == $dia ? 'selected' : ''
                        }}>{{ $dia }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Horário da Reunião</label>
                <input type="time" name="hora_reuniao"
                    value="{{ old('hora_reuniao', $grupo->hora_reuniao ? substr($grupo->hora_reuniao, 0, 5) : '') }}">
            </div>
            <div class="form-group">
                <label>Local da Reunião</label>
                <input type="text" name="local_reuniao" value="{{ old('local_reuniao', $grupo->local_reuniao) }}">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="ativo">
                    <option value="1" {{ old('ativo', $grupo->ativo ? '1' : '0') == '1' ? 'selected' : '' }}>✅ Ativo
                    </option>
                    <option value="0" {{ old('ativo', $grupo->ativo ? '1' : '0') == '0' ? 'selected' : '' }}>⏸ Inativo
                    </option>
                </select>
            </div>
            <div class="form-group" style="grid-column:span 2;">
                <label>Descrição</label>
                <textarea name="descricao">{{ old('descricao', $grupo->descricao) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
            <a href="{{ route('grupos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection