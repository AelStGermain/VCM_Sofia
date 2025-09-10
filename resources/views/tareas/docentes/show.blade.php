@extends('layouts.app')

@section('title', 'Detalle de Tarea - Docente')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🔍 Detalle de Tarea</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $tarea->titulo }}</h4>

            <p><strong>Descripción:</strong> {{ $tarea->descripcion ?? 'Sin descripción' }}</p>

            <p>
                <strong>Estado:</strong>
                <span class="badge 
                    @if($tarea->estado === 'pendiente') bg-warning
                    @elseif($tarea->estado === 'en progreso') bg-primary
                    @elseif($tarea->estado === 'completada') bg-success
                    @endif">
                    {{ ucfirst($tarea->estado) }}
                </span>
            </p>

            <p><strong>Fecha de Entrega:</strong> {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}</p>

            <p><strong>Estudiante Asignado:</strong>
                @if($tarea->estudiante)
                    {{ $tarea->estudiante->name }} ({{ $tarea->estudiante->email }})
                @else
                    <span class="text-muted">No asignado</span>
                @endif
            </p>

            <p><strong>Proyecto:</strong>
                @if($tarea->proyecto)
                    <a href="{{ route('proyectos.show', $tarea->proyecto->id) }}">
                        {{ $tarea->proyecto->nombre }}
                    </a>
                @else
                    <span class="text-muted">No vinculado</span>
                @endif
            </p>

            <div class="mt-4">
                <a href="{{ route('tareas.edit', $tarea->id) }}" class="btn btn-outline-secondary">Editar</a>
                <a href="{{ route('tareas.index') }}" class="btn btn-outline-primary">Volver al listado</a>
            </div>
        </div>
    </div>
</div>
@endsection
