<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalRole extends Model
{
    use HasFactory;

    protected $table = 'pl_roles';

    protected $fillable = [
        'ficha_empleado',
        'rol_id',
        'fecha_asignado'
    ];
}
