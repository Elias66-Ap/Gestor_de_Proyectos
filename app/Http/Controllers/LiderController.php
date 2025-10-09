<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('layouts.app_lider', compact('user'));
    }

    public function index(){
        return view('lider.inicio');
    }
}
