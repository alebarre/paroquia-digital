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
    <form method="POST" action="{{ route('fieis.update', $fiel) }}" enctype="multipart/form-data" id="fiel-form">
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
                    <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $fiel->cpf) }}"
                        placeholder="000.000.000-00" maxlength="14" required>
                    <small id="cpf-error" style="color: #ef4444; display: none;"></small>
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
                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" name="cep" id="cep" value="{{ old('cep', $fiel->cep) }}" placeholder="00000-000"
                        maxlength="9">
                    <small id="cep-error" style="color: #ef4444; display: none;"></small>
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone', $fiel->telefone) }}">
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $fiel->email) }}">
                </div>
                <div class="form-group">
                    <label>Endereço</label>
                    <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $fiel->endereco) }}">
                </div>
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $fiel->bairro) }}">
                </div>
                <div class="form-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $fiel->cidade) }}">
                </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cepInput = document.getElementById('cep');
        const enderecoInput = document.getElementById('endereco');
        const bairroInput = document.getElementById('bairro');
        const cidadeInput = document.getElementById('cidade');
        const errorDisplay = document.getElementById('cep-error');

        const cpfInput = document.getElementById('cpf');
        const cpfError = document.getElementById('cpf-error');
        const form = document.getElementById('fiel-form');

        function clearAddress() {
            enderecoInput.value = '';
            bairroInput.value = '';
            cidadeInput.value = '';
        }

        function showError(msg) {
            errorDisplay.innerText = msg;
            errorDisplay.style.display = 'block';
        }

        function hideError() {
            errorDisplay.style.display = 'none';
        }

        function validateCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');
            if (cpf === '') return false;
            if (cpf.length !== 11 || /^(.)\1+$/.test(cpf)) return false;

            let add = 0;
            for (let i = 0; i < 9; i++) add += parseInt(cpf.charAt(i)) * (10 - i);
            let rev = 11 - (add % 11);
            if (rev === 10 || rev === 11) rev = 0;
            if (rev !== parseInt(cpf.charAt(9))) return false;

            add = 0;
            for (let i = 0; i < 10; i++) add += parseInt(cpf.charAt(i)) * (11 - i);
            rev = 11 - (add % 11);
            if (rev === 10 || rev === 11) rev = 0;
            if (rev !== parseInt(cpf.charAt(10))) return false;

            return true;
        }

        function applyCPFMask(value) {
            value = value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            if (value.length > 9) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, "$1.$2.$3-$4");
            } else if (value.length > 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
            } else if (value.length > 3) {
                value = value.replace(/(\d{3})(\d{1,3})/, "$1.$2");
            }
            return value;
        }

        cepInput.addEventListener('blur', function () {
            let cep = this.value.replace(/\D/g, '');
            if (cep !== "") {
                let validacep = /^[0-9]{8}$/;
                if (validacep.test(cep)) {
                    hideError();
                    const oldAddr = enderecoInput.value;
                    const oldBairro = bairroInput.value;
                    const oldCidade = cidadeInput.value;
                    enderecoInput.value = "...";
                    bairroInput.value = "...";
                    cidadeInput.value = "...";
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!("erro" in data)) {
                                enderecoInput.value = data.logradouro;
                                bairroInput.value = data.bairro;
                                cidadeInput.value = data.localidade + (data.uf ? ' - ' + data.uf : '');
                            } else {
                                enderecoInput.value = oldAddr;
                                bairroInput.value = oldBairro;
                                cidadeInput.value = oldCidade;
                                showError("CEP não encontrado.");
                            }
                        })
                        .catch(() => {
                            enderecoInput.value = oldAddr;
                            bairroInput.value = oldBairro;
                            cidadeInput.value = oldCidade;
                            showError("Erro ao buscar CEP.");
                        });
                } else {
                    showError("Formato de CEP inválido.");
                }
            }
        });

        cepInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;
        });

        cpfInput.addEventListener('input', function (e) {
            e.target.value = applyCPFMask(e.target.value);
        });

        cpfInput.addEventListener('blur', function () {
            validateCPFInput(this);
        });

        function validateCPFInput(input) {
            const cpf = input.value.replace(/\D/g, '');
            if (cpf !== "") {
                if (!validateCPF(cpf)) {
                    cpfError.innerText = "CPF inválido.";
                    cpfError.style.display = 'block';
                    input.style.borderColor = "#ef4444";
                    return false;
                } else {
                    cpfError.style.display = 'none';
                    input.style.borderColor = "";
                    return true;
                }
            } else {
                cpfError.innerText = "O CPF é obrigatório.";
                cpfError.style.display = 'block';
                input.style.borderColor = "#ef4444";
                return false;
            }
        }

        form.addEventListener('submit', function (e) {
            if (!validateCPFInput(cpfInput)) {
                e.preventDefault();
                cpfInput.focus();
            }
        });
    });
</script>
@endpush
@endsection