<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CategoriaFinanca;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $secretaria = Role::firstOrCreate(['name' => 'secretaria']);
        $padre = Role::firstOrCreate(['name' => 'padre']);

        // Criar usuário admin padrão
        $user = User::firstOrCreate(
        ['email' => 'admin@paroquia.local'],
        [
            'name' => 'Administrador',
            'password' => bcrypt('admin123'),
        ]
        );
        $user->assignRole($admin);

        // Categorias financeiras padrão
        $categoriasEntrada = [
            'Dízimo',
            'Coleta de Missa',
            'Doações',
            'Eventos / Quermesse',
            'Esmola de Missas',
        ];

        foreach ($categoriasEntrada as $nome) {
            CategoriaFinanca::firstOrCreate(['nome' => $nome, 'tipo' => 'entrada']);
        }

        $categoriasSaida = [
            'Manutenção',
            'Água e Energia',
            'Material de Escritório',
            'Obras e Reformas',
            'Alimentação',
            'Transporte',
            'Outros',
        ];

        foreach ($categoriasSaida as $nome) {
            CategoriaFinanca::firstOrCreate(['nome' => $nome, 'tipo' => 'saida']);
        }
    }
}