@extends('layouts.app')

@section('title', 'Editar Fiel')
@section('page_title', 'Fiéis')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Editar: {{ $fiel->nome_completo }}</div>
    </div>
    <a href="{{ route('fieis.show', $fiel) }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('fieis.update', $fiel) }}" enctype="multipart/form-data">
        @csrf @method('PATCH')

        @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div style="margin-bottom:20px;">
            <h3
                style="font-size:14px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Dados Pessoais</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label>Nome *</label>
                    <input type="text" name="nome" value="{{ old('nome', $fiel->nome) }}" required>
                </div>
                <div class="form-group">
                    <label>Sobrenome *</label>
                    <input type="text" name="sobrenome" value="{{ old('sobrenome', $fiel->sobrenome) }}" required>
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf', $fiel->cpf) }}">
                </div>
                <div class="form-group">
                    <label>Data de Nascimento</label>
                    <input type="date" name="data_nascimento"
                        value="{{ old('data_nascimento', $fiel->data_nascimento?->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="sexo">
                        <option value="">— Selecione —</option>
                        <option value="M" {{ old('sexo', $fiel->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo', $fiel->sexo) == 'F' ? 'selected' : '' }}>Feminino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Estado Civil</label>
                    <select name="estado_civil">
                        <option value="">— Selecione —</option>
                        @foreach(['solteiro'=>'Solteiro(a)','casado'=>'Casado(a)','divorciado'=>'Divorciado(a)','viuvo'=>'Viúvo(a)']
                        as $val => $lbl)
                        <option value="{{ $val }}" {{ old('estado_civil', $fiel->estado_civil) == $val ? 'selected' : ''
                            }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="ativo" {{ old('status', $fiel->status) == 'ativo' ? 'selected' : '' }}>✅ Ativo
                        </option>
                        <option value="inativo" {{ old('status', $fiel->status) == 'inativo' ? 'selected' : '' }}>⏸
                            Inativo</option>
                        <option value="falecido" {{ old('status', $fiel->status) == 'falecido' ? 'selected' : '' }}>🕊
                            Falecido</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Família</label>
                    <select name="familia_id">
                        <option value="">— Nenhuma —</option>
                        @foreach($familias as $familia)
                        <option value="{{ $familia->id }}" {{ old('familia_id', $fiel->familia_id) == $familia->id ?
                            'selected' : '' }}>
                            {{ $familia->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <h3
                style="font-size:14px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Contato e Endereço</h3>
            <div class="form-grid">
                <div class="form-group"><label>Telefone</label><input type="text" name="telefone"
                        value="{{ old('telefone', $fiel->telefone) }}"></div>
                <div class="form-group"><label>E-mail</label><input type="email" name="email"
                        value="{{ old('email', $fiel->email) }}"></div>
                <div class="form-group"><label>Endereço</label><input type="text" name="endereco"
                        value="{{ old('endereco', $fiel->endereco) }}"></div>
                <div class="form-group"><label>Bairro</label><input type="text" name="bairro"
                        value="{{ old('bairro', $fiel->bairro) }}"></div>
                <div class="form-group"><label>Cidade</label><input type="text" name="cidade"
                        value="{{ old('cidade', $fiel->cidade) }}"></div>
                <div class="form-group"><label>CEP</label><input type="text" name="cep"
                        value="{{ old('cep', $fiel->cep) }}"></div>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <h3
                style="font-size:14px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Outros</h3>
            <div class="form-grid">
                <div class="form-group" style="grid-column:span 2;">
                    <label>Observações</label>
                    <textarea name="observacoes">{{ old('observacoes', $fiel->observacoes) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" accept="image/*">
                    @if($fiel->foto)<small style="color:#64748b;">Foto atual: {{ basename($fiel->foto) }}</small>@endif
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
            <a href="{{ route('fieis.show', $fiel) }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection