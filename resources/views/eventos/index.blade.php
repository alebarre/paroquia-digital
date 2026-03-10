@extends('layouts.app')

@section('title', 'Agenda e Eventos')
@section('page_title', 'Agenda e Eventos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Agenda e Eventos</div>
        <div class="page-subtitle">Missas, retiros, novenas e outros eventos</div>
    </div>
    <a href="{{ route('eventos.create') }}" class="btn btn-primary">+ Novo Evento</a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Data Início</th>
                    <th>Local</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eventos as $evento)
                <tr>
                    <td style="font-weight:600;">{{ $evento->titulo }}</td>
                    <td>
                        @php $cores =
                        ['missa'=>'badge-blue','retiro'=>'badge-purple','novena'=>'badge-yellow','quermesse'=>'badge-green','reuniao'=>'badge-gray','outro'=>'badge-gray'];
                        @endphp
                        <span class="badge {{ $cores[$evento->tipo] ?? 'badge-gray' }}">{{ ucfirst($evento->tipo)
                            }}</span>
                    </td>
                    <td>{{ $evento->data_inicio->format('d/m/Y H:i') }}</td>
                    <td>{{ $evento->local ?? '—' }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-primary btn-sm">✏️</a>
                            <form method="POST" action="{{ route('eventos.destroy', $evento) }}"
                                onsubmit="return confirm('Remover este evento?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#94a3b8; padding:40px;">Nenhum evento cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $eventos->links() }}</div>
</div>
@endsection