<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Carbon;

class TareaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener un proyecto existente
        $proyecto = Project::first();

        // Obtener un docente y un estudiante
        $docente = User::whereIn('role_id', [3, 4])->first();
        $estudiante = User::where('role_id', 5)->first();

        if (!$proyecto || !$docente || !$estudiante) {
            $this->command->warn('No se encontraron datos suficientes para poblar tareas.');
            return;
        }

        // Crear tareas de ejemplo
        Tarea::create([
            'titulo' => 'Revisión de objetivos del proyecto',
            'descripcion' => 'Analizar si los objetivos están alineados con el impacto social esperado.',
            'estado' => 'pendiente',
            'fecha_entrega' => Carbon::now()->addDays(5),
            'project_id' => $proyecto->id,
            'docente_id' => $docente->id,
            'asignada_a' => $estudiante->id,
        ]);

        Tarea::create([
            'titulo' => 'Entrega de informe preliminar',
            'descripcion' => 'Redactar el primer informe de avance con datos recopilados.',
            'estado' => 'en progreso',
            'fecha_entrega' => Carbon::now()->addDays(10),
            'project_id' => $proyecto->id,
            'docente_id' => $docente->id,
            'asignada_a' => $estudiante->id,
        ]);

        Tarea::create([
            'titulo' => 'Validación con organización aliada',
            'descripcion' => 'Coordinar reunión con la organización para validar el enfoque del proyecto.',
            'estado' => 'pendiente',
            'fecha_entrega' => Carbon::now()->addDays(7),
            'project_id' => $proyecto->id,
            'docente_id' => $docente->id,
            'asignada_a' => null, // aún no asignada
        ]);
    }
}
