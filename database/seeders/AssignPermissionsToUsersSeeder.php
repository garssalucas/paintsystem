<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AssignPermissionsToUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Obter todos os usuários
        $users = User::all();

        foreach ($users as $user) {
            // Verificar a área do usuário e atribuir a permissão correspondente
            $area = $user->area;

            // Verifica se a permissão existe e atribui ao usuário
            if (in_array($area, ['gerencia', 'administracao', 'vendas', 'laboratorio'])) {
                $permission = Permission::findByName($area);
                $user->givePermissionTo($permission);
            }
        }
    }
}
