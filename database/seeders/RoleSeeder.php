<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'administrador', 'description' => 'Usuario administrador del sistema'],
            ['id' => 2, 'name' => 'coordinador', 'description' => 'Coordinador académico'],
            ['id' => 3, 'name' => 'docente', 'description' => 'Profesor o docente'],
            ['id' => 4, 'name' => 'tutor', 'description' => 'Tutor académico'],
            ['id' => 5, 'name' => 'estudiante', 'description' => 'Estudiante del instituto'],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(['id' => $roleData['id']], $roleData);
        }

        echo "🎯 Roles institucionales insertados correctamente.\n";
    }
}
