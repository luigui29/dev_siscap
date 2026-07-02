<?php

namespace App\Models;

use App\Observers\PersonalProgramacionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PersonalProgramacionObserver::class)]
class PersonalProgramacion extends Model
{
    protected $table = 'pl_programaciones';

    protected $fillable = [
        'estatus',
        'causa',
    ];

    protected function casts(): array
    {
        return [
            'estatus' => 'boolean',
        ];
    }
}
