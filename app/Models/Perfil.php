<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';

    protected $fillable = [
        'id_usu',
        'nombre',
        'apellido',
        'apodo',
        'telefono',
        'fecha_nacimiento',
        'hobby',
        'habilidades',
        'imagen',
    ];
    protected $primaryKey = 'id_usu';

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usu');
    }

    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        return asset('images/default.jpeg');
    }
}
