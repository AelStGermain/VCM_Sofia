@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h1 class="text-3xl font-bold text-blue-900 mb-4">Panel Docente</h1>

        <p class="mb-6 text-gray-700">Bienvenida, {{ auth()->user()->name }}. Aquí puedes gestionar tus proyectos, tareas y reportes académicos.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('proyectos.index') }}" class="bg-blue-100 p-4 rounded shadow hover:bg-blue-200">
                <h2 class="text-lg font-semibold">Mis Proyectos</h2>
                <p class="text-sm text-gray-600">Ver, editar o crear proyectos académicos.</p>
            </a>

            <a href="{{ route('tareas.index') }}" class="bg-blue-100 p-4 rounded shadow hover:bg-blue-200">
                <h2 class="text-lg font-semibold">Tareas</h2>
                <p class="text-sm text-gray-600">Gestiona tareas asignadas a tus proyectos.</p>
            </a>

            <a href="{{ route('reportes.index') }}" class="bg-blue-100 p-4 rounded shadow hover:bg-blue-200">
                <h2 class="text-lg font-semibold">Reportes</h2>
                <p class="text-sm text-gray-600">Genera reportes institucionales.</p>
            </a>
        </div>
    </div>
@endsection
