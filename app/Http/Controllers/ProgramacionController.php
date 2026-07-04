<?php

namespace App\Http\Controllers;

class ProgramacionController extends Controller
{
    public function index($pestania = null)
    {
        return view('programaciones', compact('pestania'));
    }
}
