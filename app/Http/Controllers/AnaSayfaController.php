<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnaSayfaController extends Controller
{
    public function anaSayfa()
    {
        return view('ana_sayfa');
    }
}
