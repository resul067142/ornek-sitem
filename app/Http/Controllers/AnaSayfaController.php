<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnaSayfaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function anaSayfa()
    {
        return view('ana_sayfa');
    }
}
