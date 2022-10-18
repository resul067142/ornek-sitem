<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class DovizCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:doviz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Döviz verilerini çeker.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $base_url = 'https://metals-api.com/api/latest';

        $params = [
            'access_key' => config('services.metals-api.access_key'),
            'base' => 'TRY',
            'symbols' => 'XAU,XAG,XPD,XPT,XRH'
        ];

        $service = Http::get(
            $base_url.'?'.Arr::query($params)
        );

        print_r($service->object());
    }
}
