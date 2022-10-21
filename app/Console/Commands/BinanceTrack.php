<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Binance\API;
use Binance\RateLimiter;

use App\Events\BinanceEvent;

class BinanceTrack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binance:track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Binance üzereinden kripto verilerini izler.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new API(config('services.binance.api_key'), config('services.binance.api_secret'));
        $api = new RateLimiter($api);

        while(true)
        {
            $price = $api->price("BTCTRY");

            event(new BinanceEvent([
                'key' => 'BTCTRY',
                'value' => $price
            ]));

            print_r($price);

            sleep(1);
        }
    }
}
