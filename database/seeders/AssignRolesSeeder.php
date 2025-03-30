<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    public function run()
    {
        // Defina os usuários e seus respectivos papéis
        $usersRoles = [
            1 => 'administradores', // Usuário com ID 1 será administrador
            2 => 'gerentes',
            3 => 'laboratorios',
            4 => 'vendedores',
        ];

        foreach ($usersRoles as $userId => $roleName) {
            $user = User::find($userId);

            if ($user) {
                $role = Role::where('name', $roleName)->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }
        }
    }
}