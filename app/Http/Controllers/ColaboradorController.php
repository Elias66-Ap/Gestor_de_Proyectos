<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class ColaboradorController extends Controller
{
    public function __construct(){
        $this->middleware('auth:usuario');
    }

    public function inicio(){
        $user = auth()->guard('usuario')->user();
        return view('colab.inicio', compact('user'));
    }

    public function equipo(){
        return view('colab.equipo');
    }

    public function notificacion(){
        return view('colab.notificaciones');
    }

    public function miPerfil(){
        $user = auth()->guard('usuario')->user();
        return view('colab.perfil', compact('user'));
    }

    public function tareas(){
        return view('colab.tareas');
    }

    
}
