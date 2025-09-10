<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'roles';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relación: un rol puede tener muchos usuarios
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
