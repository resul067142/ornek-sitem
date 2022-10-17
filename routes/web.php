<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnaSayfaController;
use App\Http\Controllers\UyelikController;

Route::get('/', [ AnaSayfaController::class, 'anaSayfa' ])->name('ana_sayfa');
Route::get('uyelik/uye-ol', [ UyelikController::class, 'uyeOl' ])->name('uyelik.uye_ol');
Route::post('uyelik/uye-ol', [ UyelikController::class, 'uyeOlKayit' ])->name('uyelik.uye_ol.kayit');
Route::get('uyelik/dogrula/{kod}', [ UyelikController::class, 'uyelikDogrula' ])->name('uyelik.uye_ol.dogrula');
Route::get('uyelik/cikis-yap', [ UyelikController::class, 'uyeCikis' ])->name('uyelik.cikis');
Route::get('uyelik/giris-yap', [ UyelikController::class, 'girisYap' ])->name('login');
Route::post('uyelik/giris-yap', [ UyelikController::class, 'girisYapIslem' ])->name('login.islem');
Route::get('tarih-ornekleri', [ AnaSayfaController::class, 'tarihOrnekleri' ]);

Route::get('auth/redirect', [ UyelikController::class, 'githubBaglan' ])->name('uyelik.github.baglan');
Route::get('uyelik/github-ile-baglan', [ UyelikController::class, 'githubGeriDonus' ]);
