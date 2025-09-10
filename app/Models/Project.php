<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'user_id',
        'nombre',
        'institute_id',
        'area_academica_id',
        'estado_id',
        'fecha_inicio',
        'fecha_fin',
        'responsable',
        'correo_responsable',
        'progreso',
        'descripcion_general',
        'funcionalidades_principales',
        'restricciones',
    ];

    /**
     * Usuario creador del proyecto
     */
    public function creador()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Relación con tareas del proyecto
     */
    public function tareas()
    {
        return $this->hasMany(\App\Models\Tarea::class, 'project_id');
    }

    /**
     * Opciones de estado del proyecto (para formularios)
     */
    public static function getStatusOptions()
    {
        return [
            'active' => 'Activo',
            'completed' => 'Completado',
            'suspended' => 'Suspendido',
            'cancelled' => 'Cancelado',
        ];
    }

    /**
     * Relación con instituto
     */
    public function instituto()
    {
        return $this->belongsTo(\App\Models\Institute::class, 'institute_id');
    }

    /**
     * Relación con área académica
     */
    public function areaAcademica()
    {
        return $this->belongsTo(\App\Models\AreaAcademica::class, 'area_academica_id');
    }

    /**
     * Relación con estado del proyecto
     */
    public function estado()
    {
        return $this->belongsTo(\App\Models\EstadoProyecto::class, 'estado_id');
    }
}
