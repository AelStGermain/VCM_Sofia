<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'fecha_entrega',
        'project_id',
        'docente_id',
        'asignada_a',
    ];

    /**
     * Proyecto al que pertenece la tarea
     */
    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Docente responsable de la tarea
     */
    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    /**
     * Estudiante asignado a la tarea
     */
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'asignada_a');
    }
}
