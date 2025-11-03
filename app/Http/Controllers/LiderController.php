<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;

class LiderController extends Controller
{
    protected $url;
    public function __construct(){
        $this->middleware('auth:usuario');
        $this->url=env('URL_SERVER_API','127.0.0.1:8000' );
    }

    public function inicio(){
        $user = auth()->guard('usuario')->user();
        return view('lider.inicio', compact('user'));
    }

    public function index(){
        return view('lider.inicio');
    }

    public function proyectos()
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
        return view('lider.proyectos', compact('proyectos'));
    }

    public function colaboradores(){
        return view('lider.colaboradores');
    }
    public function notificacion(){
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
    public function perfil(){
        $usuario = auth()->guard('usuario')->user();
        $id = $usuario->id;

        $url = env('URL_SERVER_API', 'http://localhost:8000');
        $response = Http::get($url. "/mi-perfil/{$id}");

        if($response->successful()){
            $user = $response->json()['data'] ?? null;

            return view('lider.perfil', compact('user'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudo obtener el perfil.']);
    }

    public function tareas(){
        return view('lider.tareas');
    }
    public function equipo(){
        return view('lider.equipo');
    }
}
