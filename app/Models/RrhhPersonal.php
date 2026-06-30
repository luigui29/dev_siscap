<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class RrhhPersonal extends Model
{
    protected $connection = 'pgsql_sap';
    protected $table = 'tbl_rrhh_personal';
    protected $primaryKey = 'ficha';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nombre_empleado',
        'texto_cargo',
        'texto_unidad',
        'texto_gerencia',
        'texto_status',
        'centro_costo',
        'centro_txt'
    ];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('texto_status', 'ACTIVO');
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_usuario', 'ficha');
    }
}
