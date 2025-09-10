<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador si no existe
        $adminRole = Role::where('name', 'administrador')->first();

        User::firstOrCreate(
            ['email' => 'admin@nexuscompendium.cl'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id,
                'activo' => true,
            ]
        );

        // Aquí puedes seguir con el resto de tus seeders o inserciones
        // Ejemplo:
        // $this->call([
        //     RoleSeeder::class,
        //     RegionesSeeder::class,
        //     TiposDocumentoSeeder::class,
        // ]);
    }
}
