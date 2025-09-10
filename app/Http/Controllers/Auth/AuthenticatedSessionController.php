<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validación de credenciales
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intento de autenticación
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Regenerar sesión
        $request->session()->regenerate();

        // Redirección según rol
        $user = Auth::user();

        if ($user->role && $user->role->nombre === 'docente') {
            return redirect()->route('dashboard.docente');
        }

        if ($user->role && $user->role->nombre === 'estudiante') {
            return redirect()->route('dashboard.estudiante');
        }

        // Fallback para otros roles
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
