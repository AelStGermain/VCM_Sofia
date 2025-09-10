<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // 1. Validación de datos
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'string', 'in:docente,estudiante'],
        ]);

        // 2. Buscar el rol por nombre
        $role = Role::where('nombre', $validated['role'])->first();

        if (!$role) {
            return back()->withErrors(['role' => 'El rol seleccionado no es válido.'])->withInput();
        }

        // 3. Crear el usuario con el rol asignado
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
        ]);

        // 4. Disparar evento de registro
        event(new Registered($user));

        // 5. Autenticación y redirección
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registro exitoso. Bienvenida, ' . $user->name);
    }
}
