<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login'); // Muestra la vista de inicio de sesión
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticación como usuario normal
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Verificar si el usuario tiene un rol de administrador
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Redirigir usuarios normales
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Intentar autenticación como administrador usando el guard 'admin'
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        // Si ambas autenticaciones fallan
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); // Cerrar sesión del usuario

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

