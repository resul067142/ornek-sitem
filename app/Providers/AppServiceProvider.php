<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\UyelerObserver;
use App\Models\Uyeler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Uyeler::observe(UyelerObserver::class);
    }
}
