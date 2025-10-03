<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.inicio');
    }

    public function login(Request $request)
    {

        $credenciales = $request->only('correo', 'passwordd');

        $user = \App\Models\Usuario::where('correo', $credenciales['correo'])->first();

        if ($user && Hash::check($credenciales['passwordd'], $user->passwordd)) {
            Auth::guard('usuario')->login($user);

            switch ($user->rol) {
                case 'Administrador':
                    return redirect()->intended('/admin/inicio');
                case 'Lider':
                    return redirect()->intended('/lider/inicio');
                case 'Colaborador':
                    return redirect()->intended('/colab/inicio');
                default:
                    return redirect()->intended('/');
            }
        }

        return back()->withErrors(['correo' => 'Las datos no coinciden con nuestros registros.']);
    }

    public function logout(Request $request)
    {

        Auth::guard('usuario')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
