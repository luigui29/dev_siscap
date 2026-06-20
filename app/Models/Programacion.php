<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
     use HasFactory;

     protected $table = 'tbl_programaciones';
     protected $guarded = [];

     protected $casts = [
          'fecha' => 'datetime',
          'desde' => 'datetime',
          'hasta' => 'datetime',
          'aprobado' => 'boolean',
          'ejecutado' => 'boolean',
          'extra' => 'boolean',
     ];

     public function actividad()
     {
          return $this->belongsTo(Actividad::class, 'actividad_id');
     }

     public function subactividad()
     {
          return $this->belongsTo(Subactividad::class, 'subactividad_id');
     }

     public function facilitador()
     {
          return $this->belongsTo(Facilitador::class, 'facilitador_id');
     }
}
