<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    protected $table = 'pl_experiencia_laboral';

    protected $fillable = [
        'ficha_empleado',
        'cargo_desempeñado',
        'empresa',
        'desde',
        'hasta',
        'observacion'
    ];
}
