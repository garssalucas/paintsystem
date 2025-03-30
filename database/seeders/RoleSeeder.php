<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Definição dos papéis e suas respectivas áreas
        $roles = [
            'administradores' => ['administracao'],
            'gerentes' => ['administracao', 'gerencia'],
            'laboratorios' => ['administracao', 'gerencia', 'laboratorio'],
            'vendedores' => ['administracao', 'gerencia', 'vendas'],
        ];

        // Criar os papéis
        foreach ($roles as $roleName => $areas) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Salvar as áreas como metadado (se necessário, pode ser usado em políticas de acesso)
            $role->syncPermissions($areas);
        }
    }
}