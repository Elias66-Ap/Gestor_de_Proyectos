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
    public function __construct(){
        $this->middleware('auth:usuario');
    }

    public function inicio(){
        $user = auth()->guard('usuario')->user();
        return view('lider.inicio', compact('user'));
    }

    public function index(){
        return view('lider.inicio');
    }

    public function proyectos(){
        return view('lider.proyectos');
    }

    public function colaboradores(){
        return view('lider.colaboradores');
    }
    public function notificacion(){
        return view('lider.notificacion');
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
