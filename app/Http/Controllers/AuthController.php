<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $sucursales = Sucursal::all();
        return view('auth.register', compact('sucursales'));
    }

    public function register(RegisterRequest $request)
    {
        try {
            User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // NO loguear automáticamente
            return redirect()->route('login')
                ->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar usuario'])->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('productos')
                ->with('success', 'Sesión iniciada correctamente');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}
