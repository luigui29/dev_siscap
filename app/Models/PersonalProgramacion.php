<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalProgramacion extends Model
{
    protected $table = 'pl_programaciones';
    
    protected $fillable = [
        'estatus',
        'causa'
    ];

     protected function casts(): array
    {
        return [
            'estatus' => 'boolean',
        ];
    }
    
}
