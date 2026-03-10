<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /** Roles que o admin pode atribuir (nunca 'admin') */
    private array $rolesPermitidas = ['secretaria', 'padre'];

    public function index()
    {
        $usuarios = User::with('roles')
            ->whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'))
            ->orWhereHas('roles', fn($q) => $q->whereIn('name', $this->rolesPermitidas))
            ->orderBy('name')
            ->get();

        // Inclui o próprio admin na listagem
        $usuarios = User::with('roles')->orderBy('name')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::whereIn('name', $this->rolesPermitidas)->get();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:secretaria,padre',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('usuarios.index')
            ->with('success', "Usuário \"{$user->name}\" criado com sucesso!");
    }

    public function edit(User $usuario)
    {
        // Bloqueia edição do próprio admin via esta interface (use o perfil)
        if ($usuario->hasRole('admin') && $usuario->id !== Auth::id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Não é possível editar outro administrador.');
        }

        $roles = Role::whereIn('name', $this->rolesPermitidas)->get();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => "required|email|unique:users,email,{$usuario->id}",
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:secretaria,padre',
        ]);

        $usuario->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // Só atualiza a senha se uma nova foi fornecida
            ...($validated['password'] ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        // Sincroniza role (remove a anterior e aplica a nova)
        $usuario->syncRoles([$validated['role']]);

        return redirect()->route('usuarios.index')
            ->with('success', "Usuário \"{$usuario->name}\" atualizado!");
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === Auth::id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        $nome = $usuario->name;
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', "Usuário \"{$nome}\" removido.");
    }
}