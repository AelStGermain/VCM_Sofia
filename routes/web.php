<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioController;

// Ruta principal - Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// Redirección general post-login (fallback)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboards diferenciados por rol
Route::get('/dashboard/docente', function () {
    return view('dashboard.docente');
})->middleware(['auth', 'verified'])->name('dashboard.docente');

Route::get('/dashboard/estudiante', function () {
    return view('dashboard.estudiante');
})->middleware(['auth', 'verified'])->name('dashboard.estudiante');

// Rutas para proyectos (CRUD completo protegido)
Route::resource('proyectos', ProjectController::class)->middleware('auth');

// Rutas adicionales para proyectos (acceso diferenciado por rol)
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth');

// Rutas para tareas
Route::middleware('auth')->group(function () {
    Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/{id}', [TareaController::class, 'show'])->name('tareas.show');
    Route::get('/tareas/{id}/edit', [TareaController::class, 'edit'])->name('tareas.edit');
    Route::put('/tareas/{id}', [TareaController::class, 'update'])->name('tareas.update');
});

// Rutas para actores de interés
Route::middleware('auth')->group(function () {
    Route::get('/actores', fn() => view('actores.index'))->name('actores.index');
    Route::get('/actores/crear', fn() => view('actores.create'));
    Route::get('/actores/{id}', fn($id) => view('actores.show', ['id' => $id]));
    Route::get('/actores/{id}/editar', fn($id) => view('actores.edit', ['id' => $id]));
    Route::post('/actores', fn() => redirect('/actores')->with('success', 'Actor creado exitosamente'));
    Route::put('/actores/{id}', fn($id) => redirect('/actores')->with('success', 'Actor actualizado exitosamente'));
});

// Rutas para reportes
Route::middleware('auth')->group(function () {
    Route::get('/reportes', fn() => view('reportes.index'))->name('reportes.index');
    Route::get('/reportes/generar', fn() => view('reportes.generar'));
});

// Rutas para usuarios
Route::resource('usuarios', UsuarioController::class)->middleware('auth');

// Ruta de redirección temporal para menú
Route::get('/institutos', fn() => redirect('/actores'));

// Vista del asistente
Route::get('/chatgpt', fn() => view('components.chatgpt'))->name('chatgpt.view')->middleware('auth');

// API para la petición a ChatGPT
Route::post('/chatgpt/ask', [ChatGPTController::class, 'askChatGPT'])->name('chatgpt.ask')->middleware('auth');
