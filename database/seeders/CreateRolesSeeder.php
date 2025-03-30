<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRolesSeeder extends Seeder
{
    public function run()
    {
        // Criando os papéis
        Role::firstOrCreate(['name' => 'administradores']);
        Role::firstOrCreate(['name' => 'gerentes']);
        Role::firstOrCreate(['name' => 'laboratorios']);
        Role::firstOrCreate(['name' => 'vendedores']);
    }
}