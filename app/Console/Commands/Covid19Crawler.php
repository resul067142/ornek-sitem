<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Covid19Crawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:covid19';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sağlık bakanlığından covid19 verilerini toplar.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $http = Http::get('https://covid19.saglik.gov.tr/');

        if ($http->failed())
        {
            $this->error('Sağlık bakanlığı sitesine bağlanılamıyor.');

            return false;
        }

        $son_durum = Str::between($http->body(), 'var sondurumjson = ', ';var haftalikdurumjson = ');
        $haftalik_durum = Str::between($http->body(), ';var haftalikdurumjson = ', ';//]]>');
        $son_durum_obj = @json_decode($son_durum)[0];
        $haftalik_durum_obj = @json_decode($haftalik_durum)[0];

        if ($son_durum_obj)
        {
            print_r($son_durum_obj);
        }
        else
            $this->error('Son durum objesi geçersiz.');

        if ($haftalik_durum_obj)
        {
            print_r($haftalik_durum_obj);
        }
        else
            $this->error('Haftalık durum objesi geçersiz.');
    }
}
