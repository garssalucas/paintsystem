<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Lucas Garssa',
            'email' => 'garssa.lucas@gmail.com',
            'password' => Hash::make('bicsin-sanVib-7zethu'),
            'status' => 1,
            'atende_rua' => 0,
            'area'=> 'administracao',
        ]);

        $this->call([
            PermissionSeeder::class,
            AssignPermissionsToUsersSeeder::class,
        ]);

    }
}
