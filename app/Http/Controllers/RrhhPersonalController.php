<?php

namespace App\Http\Controllers;

class RrhhPersonalController extends Controller
{
    public function index($pestania = null)
    {
        return view('perfiles', compact('pestania'));
    }
}
