<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilitador extends Model
{
     use HasFactory;

     protected $table = 'tbl_facilitadores';
     protected $guarded = [];
}
