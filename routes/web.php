<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\TareaController;


// Ruta principal - Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas para proyectos
Route::resource('proyectos', ProjectController::class)->middleware('auth');

// Rutas para proyectos
Route::resource('proyectos', ProjectController::class)->middleware('auth');

// Rutas para tareas
Route::middleware('auth')->group(function () {
    Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/{id}', [TareaController::class, 'show'])->name('tareas.show');
    Route::get('/tareas/{id}/edit', [TareaController::class, 'edit'])->name('tareas.edit');
    Route::put('/tareas/{id}', [TareaController::class, 'update'])->name('tareas.update');
});

// Rutas para actores de interés
Route::get('/actores', function () {
    return view('actores.index');
})->middleware('auth')->name('actores.index');

Route::get('/actores/crear', function () {
    return view('actores.create');
})->middleware('auth');

Route::get('/actores/{id}', function ($id) {
    return view('actores.show', ['id' => $id]);
})->middleware('auth');

Route::get('/actores/{id}/editar', function ($id) {
    return view('actores.edit', ['id' => $id]);
})->middleware('auth');

// POST para procesar formularios de actores
Route::post('/actores', function () {
    return redirect('/actores')->with('success', 'Actor creado exitosamente');
})->middleware('auth');

Route::put('/actores/{id}', function ($id) {
    return redirect('/actores')->with('success', 'Actor actualizado exitosamente');
})->middleware('auth');

// Rutas para reportes
Route::get('/reportes', function () {
    return view('reportes.index');
})->middleware('auth')->name('reportes.index');

Route::get('/reportes/generar', function () {
    return view('reportes.generar');
})->middleware('auth');

// Rutas para usuarios
Route::resource('usuarios', App\Http\Controllers\UsuarioController::class)->middleware('auth');

// Ruta de redirección temporal para menú 
Route::get('/institutos', function () {
    return redirect('/actores');
});

// Vista del asistente
Route::get('/chatgpt', function () {
    return view('components.chatgpt');
})->name('chatgpt.view')->middleware('auth');

// API para la petición a ChatGPT
Route::post('/chatgpt/ask', [ChatGPTController::class, 'askChatGPT'])->name('chatgpt.ask')->middleware('auth');

// Rutas adicionales para proyectos
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth');

// Importar rutas de Breeze (login, registro, verificación, etc.)
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
