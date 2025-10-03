<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller; 


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
}
