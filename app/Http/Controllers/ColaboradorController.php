<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ColaboradorController extends Controller
{
    protected $url;
    public function __construct()
    {
        $this->middleware('auth:usuario');
        $this->url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    }

    public function inicio()
    {
        $id = auth()->guard('usuario')->id();

        $response = Http::get($this->url . "/proyectos-usuario/{$id}");

        if ($response->successful()) {
            $proyectos = $response->json()['proyectos'] ?? [];
            $tareas = $response->json()['tareas'] ?? [];

            return view('colab.inicio', compact('proyectos', 'tareas'));
        }

        return back()->withErrors(['error' => 'No se pudieron obtener los proyectos y tareas.']);
    }

    public function equipo()
    {
        return view('colab.equipo');
    }

    public function proyectos()
    {
        $id = auth()->guard('usuario')->user()->id;

        $response = Http::get($this->url . "/proyectos-colaborador/{$id}");

        if ($response->successful()) {
            $json = $response->json();
            $proyectos = $json['proyectos'] ?? [];

            /*foreach ($proyectos as $pro) {
                $pro['miembros_count'] = isset($pro['miembros'])
                    ? count($pro['miembros'])
                    : 0;
            }*/
        } else {
            $proyectos = [];
        }
        return view('colab.proyecto', compact('proyectos'));
    }

    public function notificacion()
    {
        $usuario = auth()->guard('usuario')->user();
        $id = $usuario->id;

        $response = Http::get($this->url . "/mensajes-usuario/{$id}");

        if ($response->successful()) {
            $data = $response->json()['data'] ?? [];
            // combinamos ambos arrays
            $enviados = $data['enviados'] ?? [];
            $recibidos = $data['recibidos'] ?? [];

            return view('colab.notificaciones', compact('enviados', 'recibidos'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudieron obtener los mensajes.']);
    }

    public function miPerfil()
    {
        $user = auth()->guard('usuario')->user();
        $id = $user->id;

        $response = Http::get($this->url . "/mi-perfil/{$id}");

        if ($response->successful()) {
            $user = $response->json()['data'] ?? null;

            return view('colab/perfil', compact('user'));
        }

        return redirect()->back()->withErrors(['error' => 'No se pudo obtener el perfil.']);
    }

    public function tareas()
    {
        $id = auth()->guard('usuario')->id();

        $response = Http::get($this->url . "/tareas-usuario/{$id}");

        if ($response->successful()) {
            $tareas = $response->json()['data'] ?? [];
            return view('colab.tareas', compact('tareas'));
        }

        return back()->withErrors(['error' => 'No se pudieron obtener las tareas.']);
    }

    public function subirTarea(Request $request)
    {
        // ===========================
        // LIMPIAR TEXTO DE QUILL
        // ===========================
        $quillTexto = trim(strip_tags($request->texto));

        if ($quillTexto === '' || $quillTexto === '&nbsp;' || $quillTexto === '<br>') {
            $request->merge(['texto' => null]);
        }

        // ===========================
        // VALIDACIÓN
        // ===========================
        $request->validate([
            'archivos.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,sql,txt,jpg,jpeg,png,webp',
            'texto'      => 'nullable|string',
            'id_tarea'   => 'required'
        ], [
            'archivos.*.mimes' => 'Uno o más archivos tienen un formato no permitido.',
            'id_tarea.required' => 'La tarea seleccionada no es válida.',
        ]);

        // Validación adicional: necesita archivo O texto
        if (!$request->hasFile('archivos') && empty($request->texto)) {
            return redirect()->back()
                ->with('error', 'Debes subir al menos un archivo o escribir un texto.');
        }

        // ===========================
        // ENVÍO A API
        // ===========================
        $url = env('URL_SERVER_API', 'http://localhost:8000');

        $texto    = $request->input('texto');
        $archivos = $request->file('archivos') ?? [];
        $id_tarea = $request->id_tarea;

        $multipartData = [];

        foreach ($archivos as $archivo) {
            $multipartData[] = [
                'name'     => 'archivos[]',
                'contents' => fopen($archivo->getRealPath(), 'r'),
                'filename' => $archivo->getClientOriginalName(),
            ];
        }

        if (!empty($texto)) {
            $multipartData[] = [
                'name'     => 'texto',
                'contents' => $texto,
            ];
        }

        $multipartData[] = [
            'name'     => 'id_tarea',
            'contents' => $id_tarea,
        ];

        $response = Http::asMultipart()->post($url . '/subir-tarea', $multipartData);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Tarea enviada con éxito.');
        }

        return redirect()->back()->with('error', 'Error al subir contenido: ' . $response->body());
    }
}
