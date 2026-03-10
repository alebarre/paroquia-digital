<?php

namespace App\Http\Controllers;

use App\Models\Sacramento;
use App\Models\Fiel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SacramentoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Sacramento::with('fiel')->orderByDesc('data');

        if ($tipo = $request->get('tipo')) {
            $query->where('tipo', $tipo);
        }
        if ($search = $request->get('search')) {
            $query->whereHas('fiel', fn($q) => $q->where('nome', 'like', "%$search%")->orWhere('sobrenome', 'like', "%$search%"));
        }

        $sacramentos = $query->paginate(15)->withQueryString();
        $tipos = Sacramento::TIPOS;

        return view('sacramentos.index', compact('sacramentos', 'tipos'));
    }

    public function create(Request $request): View
    {
        $fieis = Fiel::orderBy('nome')->get();
        $tipos = Sacramento::TIPOS;
        $fiel = $request->fiel_id ?Fiel::find($request->fiel_id) : null;
        return view('sacramentos.create', compact('fieis', 'tipos', 'fiel'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fiel_id' => 'required|exists:fieis,id',
            'tipo' => 'required|in:' . implode(',', array_keys(Sacramento::TIPOS)),
            'data' => 'required|date',
            'celebrante' => 'nullable|string|max:100',
            'local' => 'nullable|string|max:150',
            'padrinho' => 'nullable|string|max:100',
            'madrinha' => 'nullable|string|max:100',
            'conjuge' => 'nullable|string|max:100',
            'testemunha1' => 'nullable|string|max:100',
            'testemunha2' => 'nullable|string|max:100',
            'numero_registro' => 'nullable|string|max:50',
            'livro' => 'nullable|string|max:50',
            'folha' => 'nullable|string|max:50',
            'termo' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $sacramento = Sacramento::create($validated);

        return redirect()->route('sacramentos.show', $sacramento)
            ->with('success', 'Sacramento registrado com sucesso!');
    }

    public function show(Sacramento $sacramento): View
    {
        $sacramento->load('fiel');
        return view('sacramentos.show', compact('sacramento'));
    }

    public function edit(Sacramento $sacramento): View
    {
        $fieis = Fiel::orderBy('nome')->get();
        $tipos = Sacramento::TIPOS;
        return view('sacramentos.edit', compact('sacramento', 'fieis', 'tipos'));
    }

    public function update(Request $request, Sacramento $sacramento): RedirectResponse
    {
        $validated = $request->validate([
            'fiel_id' => 'required|exists:fieis,id',
            'tipo' => 'required|in:' . implode(',', array_keys(Sacramento::TIPOS)),
            'data' => 'required|date',
            'celebrante' => 'nullable|string|max:100',
            'local' => 'nullable|string|max:150',
            'padrinho' => 'nullable|string|max:100',
            'madrinha' => 'nullable|string|max:100',
            'conjuge' => 'nullable|string|max:100',
            'testemunha1' => 'nullable|string|max:100',
            'testemunha2' => 'nullable|string|max:100',
            'numero_registro' => 'nullable|string|max:50',
            'livro' => 'nullable|string|max:50',
            'folha' => 'nullable|string|max:50',
            'termo' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $sacramento->update($validated);

        return redirect()->route('sacramentos.show', $sacramento)
            ->with('success', 'Sacramento atualizado com sucesso!');
    }

    public function destroy(Sacramento $sacramento): RedirectResponse
    {
        $sacramento->delete();
        return redirect()->route('sacramentos.index')->with('success', 'Registro removido.');
    }

    public function certidao(Sacramento $sacramento): Response
    {
        $sacramento->load('fiel');
        $pdf = Pdf::loadView('sacramentos.certidao', compact('sacramento'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("certidao_{$sacramento->tipo}_{$sacramento->fiel->nome}.pdf");
    }
}