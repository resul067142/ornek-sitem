<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UyelikController;
use App\Http\Controllers\YetkiController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('uyelik/session', [ UyelikController::class, 'session' ]);

Route::post('uyelik/uye-ol', [ UyelikController::class, 'uyeOlKayitApi' ]);
Route::post('uyelik/giris-yap', [ UyelikController::class, 'girisYapApi' ]);
Route::get('uyelik/liste', [ UyelikController::class, 'uyelerApi' ]);
Route::post('uyelik/avatar-yukle', [ UyelikController::class, 'avatarYukle' ]);
Route::get('uyelik/hesabimi-sil', [ UyelikController::class, 'hesapSil' ]);

Route::get('yetki/roller', [ YetkiController::class, 'roller' ]);
Route::post('yetki/rol-ekle', [ YetkiController::class, 'rolEkle' ]);
Route::post('yetki/rol-sil', [ YetkiController::class, 'rolSil' ]);
Route::post('yetki/rol-yetkilendir', [ YetkiController::class, 'rolYetkilendir' ]);
Route::post('yetki/kullaniciya-rol-ata', [ YetkiController::class, 'kullaniciyaRolAta' ]);
Route::post('yetki/kullanicidan-rol-sil', [ YetkiController::class, 'kullanidanRolSil' ]);
Route::post('yetki/kullaniciya-yetki-ata', [ YetkiController::class, 'kullaniciyaYetkiAta' ]);

Route::get('yetki/yetkiler', [ YetkiController::class, 'yetkiler' ]);
Route::post('yetki/yetki-ekle', [ YetkiController::class, 'yetkiEkle' ]);
Route::post('yetki/yetki-sil', [ YetkiController::class, 'yetkiSil' ]);
