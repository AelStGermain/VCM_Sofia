@extends('layouts.app')

@section('title', 'Editar Tarea - Docente')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Editar Tarea</h2>

    <form method="POST" action="{{ route('tareas.update', $tarea->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $tarea->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion', $tarea->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="pendiente" {{ $tarea->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en progreso" {{ $tarea->estado === 'en progreso' ? 'selected' : '' }}>En progreso</option>
                <option value="completada" {{ $tarea->estado === 'completada' ? 'selected' : '' }}>Completada</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
            <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" value="{{ old('fecha_entrega', $tarea->fecha_entrega) }}">
        </div>

        <div class="mb-3">
            <label for="asignada_a" class="form-label">Asignar a Estudiante</label>
            <select name="asignada_a" id="asignada_a" class="form-select">
                <option value="">-- Sin asignar --</option>
                @foreach($estudiantes as $estudiante)
                    <option value="{{ $estudiante->id }}" {{ $tarea->asignada_a == $estudiante->id ? 'selected' : '' }}>
                        {{ $estudiante->name }} ({{ $estudiante->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('tareas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
