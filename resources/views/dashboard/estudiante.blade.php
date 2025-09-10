@extends('components.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h1 class="text-3xl font-bold text-green-900 mb-4">Panel Estudiante</h1>

        <p class="mb-6 text-gray-700">Hola, {{ auth()->user()->name }}. Aquí puedes consultar tus proyectos asignados y tareas pendientes.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('proyectos.index') }}" class="bg-green-100 p-4 rounded shadow hover:bg-green-200">
                <h2 class="text-lg font-semibold">Mis Proyectos</h2>
                <p class="text-sm text-gray-600">Consulta los proyectos en los que participas.</p>
            </a>

            <a href="{{ route('tareas.index') }}" class="bg-green-100 p-4 rounded shadow hover:bg-green-200">
                <h2 class="text-lg font-semibold">Tareas Pendientes</h2>
                <p class="text-sm text-gray-600">Revisa tus tareas asignadas y fechas de entrega.</p>
            </a>
        </div>
    </div>
@endsection
