<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function index()
    {
        $avisos = Aviso::latest('dataCadastro')->paginate(10);
        return view('avisos.index', compact('avisos'));
    }

    public function create()
    {
        return view('avisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipoCadastro' => 'required|integer|in:1,2,3',
            'dataCadastro' => 'required|date',
            'nomeAviso' => 'required|string|max:255',
            'descricaoAviso' => 'nullable|string',
        ]);

        Aviso::create($request->all());

        return redirect()->route('avisos.index')->with('success', 'Aviso cadastrado com sucesso!');
    }

    public function show(Aviso $aviso)
    {
        return view('avisos.show', compact('aviso'));
    }

    public function edit(Aviso $aviso)
    {
        return view('avisos.edit', compact('aviso'));
    }

    public function update(Request $request, Aviso $aviso)
    {
        $request->validate([
            'tipoCadastro' => 'required|integer|in:1,2,3',
            'dataCadastro' => 'required|date',
            'nomeAviso' => 'required|string|max:255',
            'descricaoAviso' => 'nullable|string',
        ]);

        $aviso->update($request->all());

        return redirect()->route('avisos.index')->with('success', 'Aviso atualizado com sucesso!');
    }

    public function destroy(Aviso $aviso)
    {
        $aviso->delete();
        return redirect()->route('avisos.index')->with('success', 'Aviso removido com sucesso!');
    }
}