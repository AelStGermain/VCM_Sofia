<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'nombre' => 'administrador', 'descripcion' => 'Usuario administrador del sistema', 'color' => '#0A2342'],
            ['id' => 2, 'nombre' => 'coordinador', 'descripcion' => 'Coordinador académico', 'color' => '#4C86A8'],
            ['id' => 3, 'nombre' => 'docente', 'descripcion' => 'Profesor o docente', 'color' => '#D9A852'],
            ['id' => 4, 'nombre' => 'tutor', 'descripcion' => 'Tutor académico', 'color' => '#6B7280'],
            ['id' => 5, 'nombre' => 'estudiante', 'descripcion' => 'Estudiante del instituto', 'color' => '#3E5902'],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(['id' => $roleData['id']], $roleData);
        }

        echo "🎯 Roles institucionales insertados correctamente.\n";
    }
}
