<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Fiel;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with('coordenador')->withCount('membrosAtivos')->orderBy('nome')->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $fieis = Fiel::orderBy('nome')->get();
        return view('grupos.create', compact('fieis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'dia_reuniao' => 'nullable|string',
            'hora_reuniao' => 'nullable',
            'local_reuniao' => 'nullable|string',
            'coordenador_id' => 'nullable|exists:fieis,id',
            'ativo' => 'boolean',
        ]);
        $validated['ativo'] = $request->boolean('ativo', true);
        Grupo::create($validated);
        return redirect()->route('grupos.index')->with('success', 'Grupo criado com sucesso!');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load('coordenador', 'membrosAtivos');
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $fieis = Fiel::orderBy('nome')->get();
        return view('grupos.edit', compact('grupo', 'fieis'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'dia_reuniao' => 'nullable|string',
            'hora_reuniao' => 'nullable',
            'local_reuniao' => 'nullable|string',
            'coordenador_id' => 'nullable|exists:fieis,id',
        ]);
        $validated['ativo'] = $request->boolean('ativo', true);
        $grupo->update($validated);
        return redirect()->route('grupos.index')->with('success', 'Grupo atualizado!');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo removido.');
    }
}