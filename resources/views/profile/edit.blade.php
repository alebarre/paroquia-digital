@extends('layouts.app')

@section('page_title', 'Meu Perfil')

@section('content')
<div class="profile-container">
    <div class="profile-grid">
        <!-- Sidebar do Perfil -->
        <div class="profile-aside">
            <div class="card profile-card">
                <div class="profile-header">
                    <div class="profile-avatar-wrapper" x-data="{ showUploadInfo: false }">
                        @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                            class="profile-main-avatar" id="avatar-preview">
                        @else
                        <div class="profile-main-initials" id="avatar-preview-initials">{{
                            strtoupper(substr($user->name, 0, 1)) }}</div>
                        @endif
                        <button type="button" @click="showUploadInfo = true" class="avatar-edit-btn"
                            title="Alterar foto">
                            <i class="fa-solid fa-camera"></i>
                        </button>

                        <!-- Modal de Informação de Upload -->
                        <div x-show="showUploadInfo" x-cloak class="modal-overlay">
                            <div class="modal-content" @click.away="showUploadInfo = false" style="text-align: left;">
                                <span class="modal-icon text-primary" style="text-align: center; display: block;"><i
                                        class="fa-solid fa-image"></i></span>
                                <h3 class="modal-title" style="text-align: center;">Atualizar Foto</h3>
                                <p class="modal-text">
                                    Para um melhor resultado, utilize uma imagem quadrada. <br><br>
                                    <strong>Formatos suportados:</strong> JPG, PNG, GIF.<br>
                                    <strong>Tamanho máximo:</strong> 2MB.
                                </p>
                                <div class="modal-buttons">
                                    <button type="button" @click="showUploadInfo = false"
                                        class="btn btn-outline">Cancelar</button>
                                    <label for="photo-upload" @click="showUploadInfo = false" class="btn btn-primary"
                                        style="cursor: pointer;">
                                        Escolher Arquivo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <p class="profile-role">
                        @php
                        $roles = $user->getRoleNames()->join(', ');
                        @endphp
                        {{ $roles ?: 'Sem papel definido' }}
                    </p>
                </div>

                <div class="profile-info-list">
                    <div class="info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Membro desde {{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="profile-main-content">
            <!-- Dados Pessoais -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-user-pen"></i> Dados Pessoais</h3>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <input type="file" name="photo" id="photo-upload" style="display: none;"
                        onchange="previewImage(this)">
                    @error('photo') <div class="alert alert-error mt-2">{{ $message }}</div> @enderror

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nome Completo</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                autocomplete="name">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                required autocomplete="username">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>

            <!-- Alterar Senha -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-key"></i> Alterar Senha</h3>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="update_password_current_password">Senha Atual</label>
                            <input type="password" name="current_password" id="update_password_current_password"
                                autocomplete="current-password">
                            @error('current_password', 'updatePassword') <span class="text-red-500 text-xs">{{ $message
                                }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="update_password_password">Nova Senha</label>
                            <input type="password" name="password" id="update_password_password"
                                autocomplete="new-password">
                            @error('password', 'updatePassword') <span class="text-red-500 text-xs">{{ $message
                                }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="update_password_password_confirmation">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation"
                                id="update_password_password_confirmation" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword') <span class="text-red-500 text-xs">{{
                                $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-accent">
                            <i class="fa-solid fa-shield-halved"></i> Atualizar Senha
                        </button>
                    </div>
                </form>
            </div>

            @if(false) {{-- Desativado conforme pedido: super admin só quem remove --}}
            <div class="card border-danger">
                <div class="card-header">
                    <h3 class="card-title text-red"><i class="fa-solid fa-triangle-exclamation"></i> Zona de Perigo</h3>
                </div>
                <p class="text-xs text-gray-500 mb-4">A exclusão da conta é permanente e não pode ser desfeita.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" x-data
                    @submit="$dispatch('confirm-action', {event: $event, message: 'Tem certeza que deseja excluir sua conta? Esta ação é irreversível.'})">
                    @csrf
                    @method('delete')
                    <div class="form-group mb-3">
                        <label for="password_deletion">Confirme sua senha para excluir</label>
                        <input type="password" name="password" id="password_deletion" class="max-w-xs">
                    </div>
                    <button type="submit" class="btn btn-danger">Excluir Conta</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 28px;
        align-items: start;
    }

    .profile-aside {
        position: sticky;
        top: 92px;
    }

    .profile-card {
        text-align: center;
        padding: 40px 24px;
    }

    .profile-header {
        margin-bottom: 30px;
    }

    .profile-avatar-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
    }

    .profile-main-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .profile-main-initials {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        font-weight: 700;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 40px;
        height: 40px;
        background: var(--accent);
        color: #1e293b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.2s;
    }

    .avatar-edit-btn:hover {
        transform: scale(1.1);
        background: #e5c048;
    }

    .profile-name {
        font-size: 22px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .profile-role {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-info-list {
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
        padding-top: 24px;
        text-align: left;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        color: #475569;
        font-size: 14px;
    }

    .info-item i {
        color: var(--accent);
        width: 16px;
    }

    .card.border-danger {
        border-top: 3px solid #ef4444;
    }

    @media (max-width: 992px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-aside {
            position: static;
        }
    }
</style>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('avatar-preview');
                const initials = document.getElementById('avatar-preview-initials');

                if (preview) {
                    preview.src = e.target.result;
                } else if (initials) {
                    // Substituir iniciais por uma nova imagem
                    const wrapper = initials.parentElement;
                    const img = document.createElement('img');
                    img.id = 'avatar-preview';
                    img.src = e.target.result;
                    img.className = 'profile-main-avatar';
                    wrapper.replaceChild(img, initials);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection