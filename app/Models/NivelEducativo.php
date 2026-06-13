<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelEducativo extends Model
{
    protected $table = 'pl_nivel_educativo';

    protected $fillable = [
        'ficha_empleado',
        'nivel_educativo',
        'titulo',
        'especialidad',
        'instituto',
        'graduado',
        'fecha_culminado',
        'ultimo_nivel'
    ];
}
