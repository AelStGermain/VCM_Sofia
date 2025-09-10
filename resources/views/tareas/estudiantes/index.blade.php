@extends('layouts.app')

@section('title', 'Mis Tareas Asignadas')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📌 Mis Tareas Asignadas</h2>

    @if($tareas->isEmpty())
        <div class="alert alert-info">
            No tienes tareas asignadas por el momento.
        </div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Entrega</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->titulo }}</td>
                        <td>
                            <span class="badge 
                                @if($tarea->estado === 'pendiente') bg-warning
                                @elseif($tarea->estado === 'en progreso') bg-primary
                                @elseif($tarea->estado === 'completada') bg-success
                                @endif">
                                {{ ucfirst($tarea->estado) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('tareas.show', $tarea->id) }}" class="btn btn-sm btn-outline-info">Ver</a>
                            <a href="{{ route('tareas.edit', $tarea->id) }}" class="btn btn-sm btn-outline-success">Actualizar Estado</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
