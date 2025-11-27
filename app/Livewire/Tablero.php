<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Tablero extends Component
{
    public $tareaId;
    public $estado;

    public function mount($tareaId, $estado)
    {
        $this->tareaId = $tareaId;
        $this->estado = $estado;
    }

    public function actualizarEstado($nuevoEstado)
    {
        $this->estado = $nuevoEstado;

        Http::patch(env('URL_SERVER_API') . "/cambiar-estado/$this->tareaId", [
            'id_tarea' => $this->tareaId,
            'estado'   => $nuevoEstado,
        ]);
    }

    public function render()
    {
        return view('livewire.tablero');
    }
}
