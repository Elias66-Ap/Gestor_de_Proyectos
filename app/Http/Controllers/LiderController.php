<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Usuario;

class LiderController extends Controller
{
    protected $url;
    public function __construct()
    {
        $this->middleware('auth:usuario');
        $this->url = env('URL_SERVER_API', '127.0.0.1:8000');
    }

    public function inicio()
    {
        $user = auth()->guard('usuario')->user();
        return view('lider.inicio', compact('user'));
    }

    public function index()
    {
        return view('lider.inicio');
    }

    public function proyectos()
    {
        $id = auth()->guard('usuario')->user()->id;

        $response = Http::get($this->url . "/proyectos-lider/{$id}");
        $res = Http::get($this->url . "/colaboradores");

        if ($response->successful() && $res->successful()) {
            $json = $response->json();
            $proyectos = $json['proyectos'] ?? [];
            $colaboradores = $res->json()['data'] ?? [];

            foreach ($proyectos as $pro) {
                $pro['miembros_count'] = isset($pro['miembros'])
                    ? count($pro['miembros'])
                    : 0;
            }
        } else {
            $proyectos = [];
            $colaboradores = [];
        }
        return view('lider.proyectos', compact('proyectos', 'colaboradores'));
    }

    public function colaboradores()
    {
        return view('lider.colaboradores');
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

            return view('lider.notificacion', compact('enviados', 'recibidos'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudieron obtener los mensajes.']);
    }
    public function perfil()
    {
        $usuario = auth()->guard('usuario')->user();
        $id = $usuario->id;

        $url = env('URL_SERVER_API', 'http://localhost:8000');
        $response = Http::get($url . "/mi-perfil/{$id}");

        if ($response->successful()) {
            $user = $response->json()['data'] ?? null;

            return view('lider.perfil', compact('user'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudo obtener el perfil.']);
    }

    public function tareas()
    {
        $id = auth()->guard('usuario')->user()->id;

        $url = env('URL_SERVER_API', 'http://localhost:8000');
        $response = Http::get($url . "/tareas-lider/{$id}");

        if ($response->successful()) {
            $tareas = $response->json()['tareas'] ?? null;

            return view('lider.tareas', compact('tareas'));
        }

        return redirect()->back()->withErrors('error', 'No se pudo obtener las tareas');
    }
    public function equipo()
    {
        return view('lider.equipo');
    }

    public function agregarMiembros(Request $request)
    {
        $data = [
            'id_proyecto' => $request->proyecto_id,
            'id_usuarios' => $request->id_usuarios
        ];

        $url = env('URL_SERVER_API', 'http://localhost:8000');
        $response = Http::post($url . '/agregar-miembros', $data);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Miembros agregados correctamente');
        } else {
            $errors = $response->json('errors', []);
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function crearTarea(Request $request, $id)
    {
        $id_user = auth()->guard('usuario')->user()->id;

        $data = [
            'titulo' => $request->nombre,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'fecha_vencimiento' => Carbon::parse($request->fecha_vencimiento)->endOfDay()->format('Y-m-d H:i:s'),
            'id_proyecto' => $id,
            'id_asignado' => $request->id_asignado,
            'id_creador' => $id_user
        ];

        $url = env('URL_SERVER_API', 'http://localhost:8000');
        $response = Http::post($url . '/tareas', $data);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Tarea creada exitosamente');
        } else {
            $errors = $response->json('errors', []);
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }
}
