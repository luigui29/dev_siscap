<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subactividad extends Model
{
     use HasFactory;

     protected $table = 'tbl_subactividades';
     protected $guarded = [];

     public function actividad()
     {
          return $this->belongsTo(Actividad::class, 'actividad_id');
     }
}
