<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnaSayfaController;
use App\Http\Controllers\UyelikController;

Route::get('/', [ AnaSayfaController::class, 'anaSayfa' ])->name('ana_sayfa');
Route::get('uyelik/uye-ol', [ UyelikController::class, 'uyeOl' ])->name('uyelik.uye_ol');
Route::post('uyelik/uye-ol', [ UyelikController::class, 'uyeOlKayit' ])->name('uyelik.uye_ol.kayit');
