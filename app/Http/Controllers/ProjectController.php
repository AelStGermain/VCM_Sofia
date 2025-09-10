<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de los recursos según el rol.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Project::query();

        // Filtros comunes
        if ($request->filled('q')) {
            $query->where('nombre', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('estado')) {
            $query->where('estado_id', $request->estado);
        }
        if ($request->filled('area')) {
            $query->where('area_academica_id', $request->area);
        }
        if ($request->filled('periodo')) {
            $periodo = $request->periodo;
            $query->where('fecha_inicio', 'like', $periodo . '%');
        }

        // Filtrado por rol
        if ($user->esDocente()) {
            // Docente ve proyectos asignados o de su área
            $query->where('docente_id', $user->id)->orWhere('area_academica_id', $user->area_academica_id);
            $view = 'proyectos.docente.index';
        } elseif ($user->esEstudiante()) {
            // Estudiante ve solo proyectos donde participa
            $query->whereHas('equipoEstudiantes', function ($q) use ($user) {
                $q->where('estudiante_id', $user->id);
            });
            $view = 'proyectos.estudiante.index';
        } else {
            abort(403, 'Rol no autorizado');
        }

        $projects = $query->get();

        // Estadísticas
        $total = $projects->count();
        $activos = $projects->where('estado_id', 1)->count();
        $planificacion = $projects->where('estado_id', 3)->count();
        $completados = $projects->where('estado_id', 2)->count();

        return view($view, compact('projects', 'total', 'activos', 'planificacion', 'completados'));
    }

    public function create()
    {
        $institutes = \App\Models\Institute::all();
        $areas = \App\Models\AreaAcademica::all();
        $estados = \App\Models\EstadoProyecto::all();
        return view('proyectos.create', compact('institutes', 'areas', 'estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'institute_id' => 'required|integer',
            'area_academica_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'responsable' => 'required|string|max:100',
            'correo_responsable' => 'required|email|max:150',
            'progreso' => 'required|integer|min:0|max:100',
            'descripcion_general' => 'required|string',
            'funcionalidades_principales' => 'required|string',
            'restricciones' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        Project::create($validated);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente.');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();

        if ($user->esDocente()) {
            return view('proyectos.docente.show', compact('project'));
        } elseif ($user->esEstudiante()) {
            // Verifica si el estudiante pertenece al equipo
            $pertenece = $project->equipoEstudiantes()->where('estudiante_id', $user->id)->exists();
            if (!$pertenece) {
                abort(403, 'No autorizado');
            }
            return view('proyectos.estudiante.show', compact('project'));
        }

        abort(403, 'Rol no autorizado');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();

        if ($user->esDocente() && $project->docente_id === $user->id) {
            $institutes = \App\Models\Institute::all();
            $areas = \App\Models\AreaAcademica::all();
            $estados = \App\Models\EstadoProyecto::all();
            return view('proyectos.docente.edit', compact('project', 'institutes', 'areas', 'estados'));
        }

        abort(403, 'No autorizado');
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();

        if (!($user->esDocente() && $project->docente_id === $user->id)) {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'institute_id' => 'required|integer',
            'area_academica_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'responsable' => 'required|string|max:100',
            'correo_responsable' => 'required|email|max:150',
            'progreso' => 'required|integer|min:0|max:100',
            'descripcion_general' => 'required|string',
            'funcionalidades_principales' => 'required|string',
            'restricciones' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('proyectos.show', $project->id)->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();

        if (!($user->esDocente() && $project->docente_id === $user->id)) {
            abort(403, 'No autorizado');
        }

        $project->delete();

        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}
