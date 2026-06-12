<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhPersonal extends Model
{
    protected $connection = 'pgsql_sap';
    protected $table = 'tbl_rrhh_personal';
    protected $primaryKey = 'ficha';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ficha',
        'nombre_empleado',
        'texto_cargo',
        'texto_unidad',
        'texto_gerencia',
        'texto_status',
        'centro_costo',
        'centro_txt'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_usuario', 'ficha');
    }
}
