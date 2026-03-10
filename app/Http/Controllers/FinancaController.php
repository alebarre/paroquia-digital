<?php

namespace App\Http\Controllers;

use App\Models\Financa;
use App\Models\CategoriaFinanca;
use App\Models\Fiel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FinancaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Financa::with('categoria', 'fiel')->orderByDesc('data');

        if ($tipo = $request->get('tipo')) {
            $query->where('tipo', $tipo);
        }
        if ($mes = $request->get('mes')) {
            $query->whereMonth('data', $mes);
        }
        if ($ano = $request->get('ano')) {
            $query->whereYear('data', $ano);
        }

        $financas = $query->paginate(20)->withQueryString();
        $totalEntradas = Financa::entradas()->whereMonth('data', now()->month)->sum('valor');
        $totalSaidas = Financa::saidas()->whereMonth('data', now()->month)->sum('valor');
        $saldo = $totalEntradas - $totalSaidas;

        return view('financas.index', compact('financas', 'totalEntradas', 'totalSaidas', 'saldo'));
    }

    public function create(): View
    {
        $categorias = CategoriaFinanca::orderBy('nome')->get();
        $fieis = Fiel::orderBy('nome')->get();
        return view('financas.create', compact('categorias', 'fieis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'categoria_id' => 'nullable|exists:categorias_financas,id',
            'fiel_id' => 'nullable|exists:fieis,id',
            'descricao' => 'required|string|max:200',
            'tipo' => 'required|in:entrada,saida',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'forma_pagamento' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        Financa::create($validated);

        return redirect()->route('financas.index')->with('success', 'Lançamento registrado com sucesso!');
    }

    public function show(Financa $financa): View
    {
        return view('financas.show', compact('financa'));
    }

    public function edit(Financa $financa): View
    {
        $categorias = CategoriaFinanca::orderBy('nome')->get();
        $fieis = Fiel::orderBy('nome')->get();
        return view('financas.edit', compact('financa', 'categorias', 'fieis'));
    }

    public function update(Request $request, Financa $financa): RedirectResponse
    {
        $validated = $request->validate([
            'categoria_id' => 'nullable|exists:categorias_financas,id',
            'fiel_id' => 'nullable|exists:fieis,id',
            'descricao' => 'required|string|max:200',
            'tipo' => 'required|in:entrada,saida',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'forma_pagamento' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $financa->update($validated);

        return redirect()->route('financas.index')->with('success', 'Lançamento atualizado!');
    }

    public function destroy(Financa $financa): RedirectResponse
    {
        $financa->delete();
        return redirect()->route('financas.index')->with('success', 'Lançamento removido.');
    }
}