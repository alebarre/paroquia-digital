@extends('layouts.app')

@section('title', 'Grupos e Pastorais')
@section('page_title', 'Grupos e Pastorais')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Grupos e Pastorais</div>
        <div class="page-subtitle">Gerencie os grupos da paróquia</div>
    </div>
    <a href="{{ route('grupos.create') }}" class="btn btn-primary">+ Novo Grupo</a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Coordenador</th>
                    <th>Reunião</th>
                    <th>Membros Ativos</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                <tr>
                    <td style="font-weight:600;">{{ $grupo->nome }}</td>
                    <td>{{ $grupo->coordenador?->nome_completo ?? '—' }}</td>
                    <td>{{ $grupo->dia_reuniao ?? '—' }} {{ $grupo->hora_reuniao ? substr($grupo->hora_reuniao, 0, 5) :
                        '' }}</td>
                    <td>{{ $grupo->membrosAtivos()->count() }}</td>
                    <td>
                        @if($grupo->ativo)
                        <span class="badge badge-green"><i class="fa-solid fa-circle-check"></i> Ativo</span>
                        @else
                        <span class="badge badge-gray"><i class="fa-solid fa-circle-pause"></i> Inativo</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('grupos.show', $grupo) }}" class="btn btn-outline btn-sm"><i
                                    class="fa-solid fa-eye"></i> Ver</a>
                            <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-pen-to-square"></i> Editar</a>
                            <form method="POST" action="{{ route('grupos.destroy', $grupo) }}"
                                onsubmit="window.dispatchEvent(new CustomEvent('confirm-action', { detail: { event: event, message: 'Remover este grupo?' } }))">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fa-solid fa-trash-can"></i> Remover</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#94a3b8; padding:40px;">Nenhum grupo cadastrado. <a
                            href="{{ route('grupos.create') }}" style="color:#2563eb;">Criar agora</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection