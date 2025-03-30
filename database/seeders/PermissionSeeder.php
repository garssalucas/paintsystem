<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $areas = ['gerencia', 'administracao', 'vendas', 'laboratorio'];

        foreach ($areas as $area) {
            Permission::firstOrCreate(['name' => $area]);
        }
    }
}
