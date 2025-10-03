<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';

    protected $fillable = [
        'imagen',
        'nombre',
        'apodo',
        'telefono',
        'fecha_nacimiento',
        'hobby',
        'habilidades',
    ];

    public $timestamps = false;
    
}
