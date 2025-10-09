<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;


class AdminController extends Controller
{

    public function __construct(){
        $this->middleware('auth:usuario');
    }

    public function inicio(){
        $user = auth()->guard('usuario')->user();
        return view('layouts.app', compact('user'));
    }

    public function index(){
        return view('admin.inicio');
    }

    public function colaboradores(){
        return view('admin.colaboradores');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|max:200',
            'rol' => 'required|string|max:50',
            'passwordd' => 'required|string|min:8'
        ]);

        if($validator->fails()){
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
