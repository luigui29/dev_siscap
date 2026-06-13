<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelIngles extends Model
{
    protected $table = 'pl_nivel_ingles';

    protected $fillable = [
        'ficha_empleado',
        'i1',
        'i2',
        'bb',
        'ba',
        'ib',
        'ia',
        'ab',
        'aa'
    ];
}
