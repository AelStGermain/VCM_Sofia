<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra listado de tareas según el rol.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->esDocente()) {
            $tareas = Tarea::where('docente_id', $user->id)->get();
            return view('tareas.docente.index', compact('tareas'));
        } elseif ($user->esEstudiante()) {
            $tareas = Tarea::where('asignada_a', $user->id)->get();
            return view('tareas.estudiante.index', compact('tareas'));
        }

        abort(403, 'Rol no autorizado');
    }

    /**
     * Muestra una tarea específica.
     */
    public function show($id)
    {
        $tarea = Tarea::findOrFail($id);
        $user = Auth::user();

        if ($user->esDocente() && $tarea->docente_id === $user->id) {
            return view('tareas.docente.show', compact('tarea'));
        } elseif ($user->esEstudiante() && $tarea->asignada_a === $user->id) {
            return view('tareas.estudiante.show', compact('tarea'));
        }

        abort(403, 'No autorizado');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $tarea = Tarea::findOrFail($id);
        $user = Auth::user();

        if ($user->esDocente() && $tarea->docente_id === $user->id) {
            return view('tareas.docente.edit', compact('tarea'));
        } elseif ($user->esEstudiante() && $tarea->asignada_a === $user->id) {
            return view('tareas.estudiante.edit', compact('tarea'));
        }

        abort(403, 'No autorizado');
    }

    /**
     * Actualiza la tarea.
     */
    public function update(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);
        $user = Auth::user();

        // Validación común
        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'estado' => 'required|string', // Ej: pendiente, en progreso, completada
            'fecha_entrega' => 'nullable|date',
        ]);

        // Docente puede actualizar todo
        if ($user->esDocente() && $tarea->docente_id === $user->id) {
            $tarea->update($validated);
            return redirect()->route('tareas.show', $tarea->id)->with('success', 'Tarea actualizada correctamente.');
        }

        // Estudiante solo puede actualizar su tarea asignada
        if ($user->esEstudiante() && $tarea->asignada_a === $user->id) {
            $tarea->update([
                'estado' => $validated['estado'],
            ]);
            return redirect()->route('tareas.show', $tarea->id)->with('success', 'Estado de la tarea actualizado.');
        }

        abort(403, 'No autorizado');
    }
}
