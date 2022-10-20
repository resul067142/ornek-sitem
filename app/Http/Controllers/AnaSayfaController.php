<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnaSayfaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([ 'tarihOrnekleri', 'ornekPush' ]);
        $this->middleware('can:publish articles')->only('tarihOrnekleri');
    }

    public function anaSayfa()
    {
        return view('ana_sayfa');
    }

    public function tarihOrnekleri()
    {
        echo '<pre>';
        echo now().PHP_EOL;
        echo date('Y-m-d H:i:s').PHP_EOL;
        echo date('d.m.Y H:i').PHP_EOL;
        echo date('d.m.Y H:i', strtotime('2020-01-01 12:00:00')).PHP_EOL;
        echo date('d.m.Y H:i', strtotime('-10 hours')).PHP_EOL;
    }

    public function ornekPush()
    {
        return view('ornek_push');
    }
}
