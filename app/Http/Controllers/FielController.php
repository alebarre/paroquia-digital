<?php

namespace App\Http\Controllers;

use App\Models\Fiel;
use App\Models\Familia;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FielController extends Controller
{
    public function index(Request $request): View
    {
        $query = Fiel::with('familia')->orderBy('nome');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%$search%")
                    ->orWhere('sobrenome', 'like', "%$search%")
                    ->orWhere('cpf', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $fieis = $query->paginate(15)->withQueryString();

        return view('fieis.index', compact('fieis'));
    }

    public function create(): View
    {
        $familias = Familia::orderBy('nome')->get();
        return view('fieis.create', compact('familias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'sobrenome' => 'required|string|max:100',
            'cpf' => 'nullable|string|max:14|unique:fieis,cpf',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'estado_civil' => 'nullable|string',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'endereco' => 'nullable|string|max:200',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:10',
            'status' => 'required|in:ativo,inativo,falecido',
            'familia_id' => 'nullable|exists:familias,id',
            'observacoes' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        Fiel::create($validated);

        return redirect()->route('fieis.index')->with('success', 'Fiel cadastrado com sucesso!');
    }

    public function show(Fiel $fiel): View
    {
        $fiel->load('familia', 'sacramentos', 'grupos', 'financas.categoria');
        return view('fieis.show', compact('fiel'));
    }

    public function edit(Fiel $fiel): View
    {
        $familias = Familia::orderBy('nome')->get();
        return view('fieis.edit', compact('fiel', 'familias'));
    }

    public function update(Request $request, Fiel $fiel): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'sobrenome' => 'required|string|max:100',
            'cpf' => 'nullable|string|max:14|unique:fieis,cpf,' . $fiel->id,
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'estado_civil' => 'nullable|string',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'endereco' => 'nullable|string|max:200',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:10',
            'status' => 'required|in:ativo,inativo,falecido',
            'familia_id' => 'nullable|exists:familias,id',
            'observacoes' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $fiel->update($validated);

        return redirect()->route('fieis.show', $fiel)->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy(Fiel $fiel): RedirectResponse
    {
        $fiel->delete();
        return redirect()->route('fieis.index')->with('success', 'Fiel removido com sucesso!');
    }
}