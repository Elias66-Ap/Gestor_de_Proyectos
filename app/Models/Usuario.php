<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';

    protected $fillable = [
        'id',
        'correo',
        'rol',
        'passwordd',
        'estado',
    ];

    protected $hidden = [
        'passwordd',
    ];

    public $timestamps = false;

    public function esAdmin(){
        return $this->rol === 'Administrador';
    }

    public function esLider(){
        return $this->rol === 'Lider';
    }

    public function esColaborador(){
        return $this->rol === 'Colaborador';
    }

    public function perfil(){
        return $this->hasOne(Perfil::class, 'id_usu');
    }
}
