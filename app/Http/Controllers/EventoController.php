<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::orderByDesc('data_inicio')->paginate(20);
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'tipo' => 'required|in:missa,retiro,novena,quermesse,reuniao,outro',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'local' => 'nullable|string|max:150',
            'descricao' => 'nullable|string',
            'recorrente' => 'boolean',
            'recorrencia' => 'nullable|string',
        ]);
        $validated['recorrente'] = $request->boolean('recorrente');
        Evento::create($validated);
        return redirect()->route('eventos.index')->with('success', 'Evento criado com sucesso!');
    }

    public function show(Evento $evento)
    {
        $evento->load('missa');
        return view('eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'tipo' => 'required|in:missa,retiro,novena,quermesse,reuniao,outro',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'local' => 'nullable|string|max:150',
            'descricao' => 'nullable|string',
        ]);
        $evento->update($validated);
        return redirect()->route('eventos.index')->with('success', 'Evento atualizado!');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento removido.');
    }
}