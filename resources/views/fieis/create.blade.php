@extends('layouts.app')

@section('title', 'Novo Fiel')
@section('page_title', 'Fiéis')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Novo Fiel</div>
        <div class="page-subtitle">Preencha os dados do paroquiano</div>
    </div>
    <a href="{{ route('fieis.index') }}" class="btn btn-outline">← Voltar</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('fieis.store') }}" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
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
                    <input type="text" name="nome" value="{{ old('nome') }}" required>
                </div>
                <div class="form-group">
                    <label>Sobrenome *</label>
                    <input type="text" name="sobrenome" value="{{ old('sobrenome') }}" required>
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00">
                </div>
                <div class="form-group">
                    <label>Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento') }}">
                </div>
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="sexo">
                        <option value="">— Selecione —</option>
                        <option value="M" {{ old('sexo')=='M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo')=='F' ? 'selected' : '' }}>Feminino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Estado Civil</label>
                    <select name="estado_civil">
                        <option value="">— Selecione —</option>
                        <option value="solteiro" {{ old('estado_civil')=='solteiro' ? 'selected' : '' }}>Solteiro(a)
                        </option>
                        <option value="casado" {{ old('estado_civil')=='casado' ? 'selected' : '' }}>Casado(a)</option>
                        <option value="divorciado" {{ old('estado_civil')=='divorciado' ? 'selected' : '' }}>
                            Divorciado(a)</option>
                        <option value="viuvo" {{ old('estado_civil')=='viuvo' ? 'selected' : '' }}>Viúvo(a)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Família</label>
                    <select name="familia_id">
                        <option value="">— Nenhuma —</option>
                        @foreach($familias as $familia)
                        <option value="{{ $familia->id }}" {{ old('familia_id')==$familia->id ? 'selected' : '' }}>
                            {{ $familia->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="ativo" {{ old('status','ativo')=='ativo' ? 'selected' : '' }}>✅ Ativo</option>
                        <option value="inativo" {{ old('status')=='inativo' ? 'selected' : '' }}>⏸ Inativo</option>
                        <option value="falecido" {{ old('status')=='falecido' ? 'selected' : '' }}>🕊 Falecido</option>
                    </select>
                </div>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <h3
                style="font-size:14px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Contato e Endereço</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label>Endereço</label>
                    <input type="text" name="endereco" value="{{ old('endereco') }}">
                </div>
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" value="{{ old('bairro') }}">
                </div>
                <div class="form-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" value="{{ old('cidade') }}">
                </div>
                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" name="cep" value="{{ old('cep') }}" placeholder="00000-000">
                </div>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <h3
                style="font-size:14px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">
                Outros</h3>
            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Observações</label>
                    <textarea name="observacoes">{{ old('observacoes') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" accept="image/*">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Salvar Fiel</button>
            <a href="{{ route('fieis.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection