<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ColaboradorController extends Controller
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
        return view('colab.inicio', compact('user'));
    }

    public function equipo()
    {
        return view('colab.equipo');
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

            return view('colab.notificaciones', compact('enviados', 'recibidos'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudieron obtener los mensajes.']);
    }

    public function miPerfil()
    {
        $user = auth()->guard('usuario')->user();
        return view('colab.perfil', compact('user'));
    }

    public function tareas()
    {
        $id = auth()->guard('usuario')->id();

        $response = Http::get($this->url . "/tareas-usuario/{$id}");

        if($response->successful()) {
            $tareas = $response->json()['data'] ?? [];
            return view('colab.tareas', compact('tareas'));
        }

        return back()->withErrors(['error' => 'No se pudieron obtener las tareas.']);
    }
}
