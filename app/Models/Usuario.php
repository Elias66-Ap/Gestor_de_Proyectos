<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';

    protected $fillable = [
        'correo',
        'rol',
        'passwordd',
        'estado',
    ];

    protected $hidden = [
        'passwordd',
    ];

    public $timestamps = false;
}
