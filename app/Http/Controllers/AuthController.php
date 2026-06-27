<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Formulario login de la aplicación.
     */
    public function showLoginForm()
    {
        // Redirigir si ya está autenticado
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Manejar una solicitud de inicio de sesión en la aplicación.
     */
    public function login(Request $request)
    {
        /* Credenciales */
        $credentials = $request->validate([
            'ficha' => ['required'],
            'password' => ['required'],
        ], [
            'ficha.required' => 'El campo "ficha" es obligatorio.',
            'password.required' => 'El campo "contraseña" es obligatorio.',
        ]);

        // Revisar si la ficha existe en la base de datos
        $user = User::where('ficha', $credentials['ficha'])->first();

        if (!$user) {
            return back()->withErrors([
                'ficha' => 'La ficha proporcionada no se encontró en la base de usuarios de SISCAP.'
            ])->withInput();
        }

        // Existe  el usuario. Proceder a intentar autenticarlo
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Usuario existe pero la contraseña es incorrecta
        return back()->withErrors([
            'password' => 'Asegúrese de que la contraseña corresponda y vuelva a intentarlo.'
        ])->withInput();
    }

    /**
     * Log out de la aplicación.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
