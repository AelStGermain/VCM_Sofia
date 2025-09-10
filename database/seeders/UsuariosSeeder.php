<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar el rol administrador
        $adminRole = Role::where('name', 'administrador')->first();

        // Crear usuario administrador si no existe
        User::firstOrCreate(
            ['email' => 'admin@nexuscompendium.cl'], // ← clave única
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin1234'), // ← cambia esto por una contraseña segura
                'role_id' => $adminRole?->id,
                'activo' => true,
            ]
        );
    }
}
