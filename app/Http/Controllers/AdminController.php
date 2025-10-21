<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Usuario;
use App\Models\Rendimiento;


class AdminController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->middleware('auth:usuario');
        $this->url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    }

    public function inicio()
    {
        $user = auth()->guard('usuario')->user();
        return view('layouts.app', compact('user'));
    }

    public function index()
    {
        return view('admin.inicio');
    }

    public function colaboradores()
    {
        $response = Http::get($this->url.'/usuarios');

        if ($response->successful()) {
            $usuarios = $response->json()['data'] ?? $response->json();
        } else {
            $usuarios = [];
        }

        return view('admin.colaboradores', compact('usuarios'));
    }

    public function equipos()
    {
        return view('admin.equipos');
    }
    public function proyecto()
    {
        $response = Http::get($this->url . '/proyectos');

        if ($response->successful()) {
            $proyectos = $response->json()['data'] ?? $response->json();
        } else {
            $proyectos = [];
        }

        return view('admin.proyecto', compact('proyectos'));
    }

    public function perfil()
    {
        $user = auth()->guard('usuario')->user();
        $user->load('perfil', 'rendimiento');
        return view('admin.perfi', compact('user'));
    }

    public function notificacion()
    {
        return view('admin.notificacion');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|max:200',
            'rol' => 'required|string|max:50',
            'passwordd' => 'required|string|min:8|confirmed'
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'rol.required' => 'Debe seleccionar un rol.',
            'passwordd.required' => 'La contraseña es obligatoria.',
            'passwordd.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'passwordd.confirmed' => 'Las contraseñas no coincide.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Usuario::create([
            'correo' => $request->correo,
            'rol' => $request->rol,
            'passwordd' => Hash::make($request->passwordd),
        ]);

        Rendimiento::create(['id_usu' => $user->id]);

        return redirect()->back()->with('success', 'Usuario registrado');
    }
}
