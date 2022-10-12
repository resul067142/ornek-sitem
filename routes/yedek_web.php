<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use Rap2hpoutre\LaravelLogViewer\LogViewerController;

use App\Mail\UyelikDogrulamaKodu;

Route::get('/', function() {
    echo config('app.deneme.merhaba');
});

// Log dosyasına log basma methodu
Route::get('log-bas', function () {
    $message = 'Merhaba bu bir log satırı.';

    Log::channel('bilgiler')->emergency($message);
    Log::channel('bilgiler')->alert($message);
    Log::channel('bilgiler')->critical($message);
    Log::channel('bilgiler')->error($message);
    Log::channel('bilgiler')->warning($message);
    Log::channel('bilgiler')->notice($message);
    Log::channel('bilgiler')->info($message);
    Log::channel('bilgiler')->debug($message);
});

// Logları görüntüleyen paketin view tarafı
Route::get('loglar', [ LogViewerController::class, 'index' ]);

Route::get('mail-test', function() {
    $kod = rand(1000, 9999);

    // db kayıt

    return new UyelikDogrulamaKodu($kod);
});
