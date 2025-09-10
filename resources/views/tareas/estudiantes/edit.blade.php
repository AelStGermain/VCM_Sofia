@extends('layouts.app')

@section('title', 'Actualizar Estado de Tarea')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✅ Actualizar Estado de la Tarea</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $tarea->titulo }}</h4>

            <p><strong>Descripción:</strong> {{ $tarea->descripcion ?? 'Sin descripción' }}</p>
            <p><strong>Fecha de Entrega:</strong> {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}</p>

            <form method="POST" action="{{ route('tareas.update', $tarea->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="pendiente" {{ $tarea->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en progreso" {{ $tarea->estado === 'en progreso' ? 'selected' : '' }}>En progreso</option>
                        <option value="completada" {{ $tarea->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Guardar Estado</button>
                <a href="{{ route('tareas.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
