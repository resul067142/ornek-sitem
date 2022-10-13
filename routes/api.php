<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UyelikController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('uyelik/uye-ol', [ UyelikController::class, 'uyeOlKayitApi' ]);

Route::get('uyelik/liste', [ UyelikController::class, 'uyelerApi' ]);
