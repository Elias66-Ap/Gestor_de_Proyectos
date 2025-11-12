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
        $user = auth()->guard('usuario')->user();
        return view('admin.inicio', compact('user'));
    }

    public function colaboradores()
    {
        $response = Http::get($this->url . '/usuarios');

        if ($response->successful()) {
            $usuarios = $response->json()['data'] ?? $response->json();
            $sin_perfil = $response->json()['sin_perfil'] ?? $response->json();
        } else {
            $usuarios = [];
            $sin_perfil =[];
        }

        return view('admin.colaboradores', compact('usuarios', 'sin_perfil'));
    }

    public function equipos()
    {
        return view('admin.equipos');
    }
    public function proyecto()
    {

        $response = Http::get($this->url . '/proyectos');

        if ($response->successful()) {
            $json = $response->json();
            $proyectos = $json['proyectos'] ?? [];

            foreach ($proyectos as $pro) {
                $pro['miembros_count'] = isset($pro['miembros'])
                    ? count($pro['miembros'])
                    : 0;
            }
        } else {
            $proyectos = [];
        }
        return view('admin.proyecto', compact('proyectos'));
    }


    public function perfil()
    {
        $usuario = auth()->guard('usuario')->user();

        $response = Http::get($this->url . "/mi-perfil/{$usuario->id}");

        if ($response->successful()) {
            $user = $response->json()['data'] ?? null;

            return view('admin.perfi', compact('user'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudo obtener el perfil.']);
    }

    public function notificacion()
    {
        $usuario = auth()->guard('usuario')->user();
        $id = $usuario->id;

        $response = Http::get($this->url . "/mensajes-usuario/{$id}");

        if ($response->successful()) {
            $data = $response->json()['data'] ?? [];
            // combinamos ambos arrays
            $enviados = $data['enviados'] ?? [];
            $recibidos = $data['recibidos'] ?? [];

            return view('admin.notificacion', compact('enviados', 'recibidos'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudieron obtener los mensajes.']);
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

    public function verProyecto($id)
    {

        $response = Http::get($this->url . "/proyectos/{$id}");

        if ($response->successful()) {
            $data = $response->json();
            $proyecto = $data['proyecto'] ?? null;
        } else {
            $proyecto = null;
        }


        return view('tablero', compact('proyecto'));
    }

    public function crearProyecto(Request $request)
    {
        $user = auth()->guard('usuario')->user();

        $data = [
            'nombre' => $request->nombre,
            'descripcion_breve' => $request->descripcion_breve,
            'descripcion_detalle' => $request->descripcion_detalle,
            'fecha_entrega' => $request->fecha_entrega,
            'id_creador' => $user->id,
            'id_lider' => $request->id_lider,
        ];


        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($this->url . '/proyectos', $data);

        dd($response->json());

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Proyecto creado exitosamente');
        } else {
            $errors = $response->json('errors', []);
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }
}
