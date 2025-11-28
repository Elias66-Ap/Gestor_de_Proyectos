<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class MensajeController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        $user = auth()->guard('usuario')->user();

        $data = [
            'asunto' => $request->asunto,
            'contenido' => $request->contenido,
            'id_remitente' => $user->id,
            'id_destinatario' => array_map('intval', $request->id_destinatario),
        ];

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000', $data);

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post($url . '/mensajes', $data);

            dump($response->json());


            if ($response->successful()) {
                return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al enviar el mensaje: ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }
}
