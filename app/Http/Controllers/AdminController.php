<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;


class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:usuario');
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
        return view('admin.colaboradores');
    }
    public function equipos()
    {
        return view('admin.equipos');
    }
    public function proyecto(){
        return view('admin.proyecto');
    }
    public function perfil(){
        return view('admin.perfi');
    }
    public function notificacion(){
        return view('admin.notificacion');
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|max:200',
            'rol' => 'required|string|max:50',
            'passwordd' => 'required|string|min:8|confirmed'
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'rol.required' => 'Debe seleccionar un rol.',
            'passwordd.required' => 'La contraseña es obligatoria.',
            'passwordd.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'passwordd.confirmed' => 'Las contraseñasb  no coincide.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new Usuario();
        $user->correo = $request->correo;
        $user->rol = $request->rol;
        $user->passwordd = Hash::make($request->passwordd);
        $user->save();

        return redirect()->back()->with('success', 'Usuario registrado');
    }
}
