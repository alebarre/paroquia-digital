@extends('layouts.app')

@section('title', 'Sacramentos')
@section('page_title', 'Sacramentos')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Sacramentos</div>
        <div class="page-subtitle">Todos os sacramentos registrados</div>
    </div>
    <a href="{{ route('sacramentos.create') }}" class="btn btn-primary">+ Registrar</a>
</div>

<div class="card">
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="🔍 Buscar por fiel..." value="{{ request('search') }}"
            style="min-width:240px;">
        <select name="tipo">
            <option value="">Todos os tipos</option>
            @foreach($tipos as $key => $label)
            <option value="{{ $key }}" {{ request('tipo')==$key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('sacramentos.index') }}" class="btn btn-outline">Limpar</a>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Fiel</th>
                    <th>Sacramento</th>
                    <th>Data</th>
                    <th>Celebrante</th>
                    <th>Local</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sacramentos as $sac)
                <tr>
                    <td>
                        <a href="{{ route('fieis.show', $sac->fiel) }}"
                            style="color:#2563eb; font-weight:600; text-decoration:none;">
                            {{ $sac->fiel->nome_completo }}
                        </a>
                    </td>
                    <td>
                        @php
                        $cores =
                        ['batismo'=>'badge-blue','primeira_eucaristia'=>'badge-yellow','crisma'=>'badge-purple',
                        'matrimonio'=>'badge-green','uncao_enfermos'=>'badge-gray','ordenacao'=>'badge-red'];
                        @endphp
                        <span class="badge {{ $cores[$sac->tipo] ?? 'badge-gray' }}">{{ $sac->tipo_label }}</span>
                    </td>
                    <td>{{ $sac->data->format('d/m/Y') }}</td>
                    <td>{{ $sac->celebrante ?? '—' }}</td>
                    <td>{{ $sac->local ?? '—' }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('sacramentos.show', $sac) }}" class="btn btn-outline btn-sm">Ver</a>
                            <a href="{{ route('sacramentos.certidao', $sac) }}" class="btn btn-success btn-sm">📄
                                PDF</a>
                            <form method="POST" action="{{ route('sacramentos.destroy', $sac) }}"
                                onsubmit="return confirm('Remover este registro?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#94a3b8; padding:40px;">Nenhum sacramento
                        encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $sacramentos->links() }}</div>
</div>
@endsection