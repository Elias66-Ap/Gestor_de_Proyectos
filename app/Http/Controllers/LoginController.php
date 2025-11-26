<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.inicio');
    }

    public function login(Request $request)
    {

        $credenciales = $request->only('correo', 'passwordd');

        $user = Usuario::where('correo', $credenciales['correo'])->first();

        if ($user && Hash::check($credenciales['passwordd'], $user->passwordd)) {
            Auth::guard('usuario')->login($user);

            if ($user->tiene_perfil == 0 && in_array($user->rol, ['Administrador', 'Lider', 'Colaborador'])) {
                return redirect()->route('crear_perfil');
            }

            if ($user->estado == 2) {
                Auth::guard('usuario')->logout();
                return redirect()->route('inicio')->withErrors(['Tu cuenta esta desabilitada']);
            }


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

    public function subirTarea(Request $request, $id)
    {

        $url = env('URL_SERVER_API', 'http://localhost:8000');

        $textos = $request->textos ?? []; // array de textos
        $archivos = $request->file('archivos') ?? []; // array de archivos

        // Crear la petición multipart
        $response = Http::withMultipartData(function ($multipart) use ($textos, $archivos) {

            // Adjuntar textos
            foreach ($textos as $i => $texto) {
                $multipart->field("textos[$i]", $texto);
            }

            // Adjuntar archivos
            foreach ($archivos as $archivo) {
                $multipart->attach('archivos[]', fopen($archivo->getRealPath(), 'r'), $archivo->getClientOriginalName());
            }
        })->post($url . "/tareas/{$id}/contenido");

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Contenido subido correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al subir el contenido');
        }
    }
}
