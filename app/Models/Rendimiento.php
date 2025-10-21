<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Rendimiento extends Model
{
    protected $table = 'rendimiento';

    protected $fillable = [
        'id',
        'id_usu',
        'tar_total',
        'tar_completadas',
        'tar_tarde',
        'rendimiento',
        'fecha_registro',
    ];

    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usu');
    }


}
