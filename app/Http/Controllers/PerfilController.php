<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function completarPerfil(Request $request)
    {
        $usuario = Auth::guard('usuario')->user();
        $id = $usuario->id;

        $user = Usuario::find($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'nullable|string|max:200',
            'apodo' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'fecha_nacimiento' => 'nullable|date',
            'hobby' => 'nullable|string',
            'habilidades' => 'nullable|array',
            'habilidades.*' => 'string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'passwordd' => 'nullable|string|min:8|confirmed',
        ],[
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpeg, png, jpg, gif.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'apellido.max' => 'El apellido no debe exceder los 200 caracteres.',
            'apodo.max' => 'El apodo no debe exceder los 100 caracteres.',
            'telefono.max' => 'El telefono no debe exceder los 15 caracteres.',
            'passwordd.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'passwordd.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
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
            'habilidades' => $request->has('habilidades') ? implode(',', $request->habilidades) : null,
            'imagen' => $imagenPath,
        ]);

        if ($request->filled('passwordd')) {
            $user->passwordd = Hash::make($request->passwordd);
        }

        $user->tiene_perfil = 1;
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

    public function editarPerfil(Request $request)
    {

        $usuario = Auth::guard('usuario')->user();
        $id = $usuario->id;

        $perfil = Perfil::where('id_usu', '=',$id)->first();

        $validator = Validator::make(
            $request->all(),
            [
                'nombre' => 'required|string|max:100',
                'apellido' => 'nullable|string|max:200',
                'apodo' => 'nullable|string|max:100',
                'telefono' => 'nullable|string|min:9',
                'fecha_nacimiento' => 'nullable|date',
                'hobby' => 'nullable|string',
                'habilidades' => 'nullable|array',
                'habilidades.*' => 'string|max:100',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
                'apellido.max' => 'El apellido no debe exceder los 200 caracteres.',
                'apodo.max' => 'El apodo no debe exceder los 100 caracteres.',
                'telefono.min' => 'Numero de telefono incorrecto.',
                'imagen.image' => 'El archivo debe ser una imagen.',
                'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpeg, png, jpg, gif.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->hasFile('imagen')){
            $imagenPath = $request->file('imagen')->store('perfil', 'public');
            $perfil->imagen = $imagenPath;
        }

        $perfil->nombre = $request->nombre;
        $perfil->apellido = $request->apellido;
        $perfil->apodo = $request->apodo;
        $perfil->telefono = $request->telefono;
        $perfil->fecha_nacimiento = $request->fecha_nacimiento;
        $perfil->hobby = $request->hobby;
        $perfil->habilidades = $request->has('habilidades') ? implode(',', $request->habilidades) : null;
        $perfil->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}
