<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Uyelik\UyeOlRequest;

class UyelikController extends Controller
{
    public function uyeOl()
    {
        return view('uyelik.uye_ol');
    }

    public function uyeOlKayit(UyeOlRequest $request)
    {
        dd($request->all());
    }
}
