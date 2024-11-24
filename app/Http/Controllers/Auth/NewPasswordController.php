<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Identificar el guard (usuario o admin) si es necesario
        $guard = $this->determineGuard($request);

        // Intentar restablecer la contraseña
        $status = Password::broker($guard)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Redirigir según el resultado
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }

    /**
     * Determine the guard for the user or admin.
     */
    protected function determineGuard(Request $request): string
    {
        // Si tienes lógica específica para distinguir entre usuarios y admins,
        // podrías hacer algo como verificar el dominio de correo electrónico
        // o tener un campo específico que determine el rol.
        // Por simplicidad, aquí asumimos 'users' o 'admins' como ejemplo.
        if ($request->is('admin/*')) {
            return 'admins'; // Nombre del broker para admins definido en config/auth.php
        }

        return 'users'; // Nombre del broker por defecto para usuarios
    }
}

