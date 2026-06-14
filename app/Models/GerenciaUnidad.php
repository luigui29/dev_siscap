<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GerenciaUnidad extends Model
{
    protected $connection = 'pgsql_sap';
    protected $table = 'vista_gerencias_unidades'; 
    
    public $timestamps = false;
}
