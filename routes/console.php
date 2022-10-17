<?php

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UyelikController;

Artisan::command('tarih:saat_yaz', function () {
    $this->comment(UyelikController::tarihSaatYaz());
})->purpose('Ekrana sadece saati yazar.');
