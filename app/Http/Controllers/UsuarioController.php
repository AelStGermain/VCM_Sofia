<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener los usuarios desde la base de datos
        // $usuarios = User::all();
        // return view('usuarios.index', compact('usuarios'));
        return view('usuarios.index');
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        // Lógica para guardar un usuario
        // User::create($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    public function show($id)
    {
        // $usuario = User::findOrFail($id);
        // return view('usuarios.show', compact('usuario'));
        return view('usuarios.show', compact('id'));
    }

    public function edit($id)
    {
        // $usuario = User::findOrFail($id);
        // return view('usuarios.edit', compact('usuario'));
        return view('usuarios.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un usuario
        // $usuario = User::findOrFail($id);
        // $usuario->update($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Lógica para eliminar un usuario
        // $usuario = User::findOrFail($id);
        // $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}