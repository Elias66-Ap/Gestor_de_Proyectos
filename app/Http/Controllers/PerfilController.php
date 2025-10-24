<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:usuario');
    }
    public function crear()
    {
        $user = Auth::guard('usuario')->user();

        if ($user->perfil) {

            switch ($user->rol) {
                case 'Administrador':
                    return redirect()->route('admin.inicio');
                case 'Lider':
                    return redirect()->route('lider.inicio');
                case 'Colaborador':
                    return redirect()->route('colab.inicio');
                default:
                    return redirect()->route('inicio');
            }
        }

        return view('crear_perfil', compact('user'));
    }

    public function guardar(Request $request)
    {
        $user = Auth::guard('usuario')->user();

        $validator = Validator::make($request->all(), [
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre' => 'required|string|max:100',
            'apellido' => 'nullable|string|max:200',
            'apodo' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'fecha_nacimiento' => 'nullable|date',
            'hobby' => 'nullable|string',
            'habilidades' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenPath = null;
        if($request->hasFile('imagen')){
            $imagenPath = $request->file('imagen')->store('perfil', 'public');
        }

        $perfil = Perfil::create([
            'id_usu' => $user->id,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'apodo' => $request->apodo,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'hobby' => $request->hobby,
            'habilidades' => $request->habilidades,
            'imagen' => $imagenPath,
        ]);


        $user->estado = 1;
        $user->save();

        switch ($user->rol) {
            case 'Administrador':
                return redirect()->route('admin.inicio')->with('success', 'Perfil completado correctamente.');
            case 'Lider':
                return redirect()->route('lider.inicio')->with('success', 'Perfil completado correctamente.');
            case 'Colaborador':
                return redirect()->route('colab.inicio')->with('success', 'Perfil completado correctamente.');
            default:
                return redirect()->route('inicio');
        }
    }

    public function editarPerfil(Request $request, $id){

        $nuevo = $request->only([
            'nombre',
            'apellido',
            'apodo',
            'fecha_nacimiento',
            'hobby',
            'habilidades',
            'imagen',
        ]);

        $url = env('URL_sERVER_API', 'http://localhost:8000');

        $response = Http::put($url."/perfiles/{$id}", $nuevo);
        $data = $response->json();

        if($response->status() === 422 && isset($data['errors'])){
            return redirect()->back()->withErrors($data['errors'])->withInput();
        }

        if($response->successful()){
            return redirect()->back()->with('success', 'Perfil Actualizado');
        }

        return redirect()->back()->with('error', 'Error al actualizar perfil');
    }
}
