<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller; 


class UsuarioController extends Controller
{

    public function __construct(){
        $this->middleware('auth:usuario');
    }

    public function index(){
        /*$pass = Hash::make('12345');
        dd($pass);*/
        return view('admin.inicio');
    }
}
