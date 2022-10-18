<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use nokogiri;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Application;

class EzanCrawler extends Command
{
    protected $base_url;

    public function __construct(Application $app)
    {
        $this->base_url = 'https://namazvakitleri.diyanet.gov.tr/tr-TR';

        parent::__construct($app);
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:ezan_vakitleri';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diyanet üzerinden ezan vakitlerini toplar.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // foreach (Redis::keys('ezan:ADANA:*') as $key)
        // {
        //     $key = explode('_', $key);

        //     print_r(json_decode(Redis::get($key[3])));
        // }

        // 1. aşama
        // Sayfaya gir ve ilk şehrin, ilk merkez ilçesini bul.

        $this->line('Diyanet bağlantısı kuruluyor.');

        $http = Http::get($this->base_url);

        if ($http->successful())
        {
            $this->info('[ok]');

            $saw = new nokogiri($http->body());

            $this->line('Ülke değerleri alınıyor.');

            $country_select = @$saw->get('select[name=country]')->toArray()[0]['option'];
            $state_select = @$saw->get('select[name=state]')->toArray()[0]['option'];

            if ($country_select)
            {
                $this->info('[ok]');

                $this->line('Türkiye aranıyor.');

                $turkiye = array_values(Arr::where($country_select, function ($item, $key) {
                    return @$item['#text'][0] == 'TÜRKİYE';
                }));

                if (count($turkiye))
                {
                    $this->info('[ok]');

                    $turkiye_kodu = $turkiye[0]['value'];

                    $this->line('Türkiye deki iller tespit ediliyor.');

                    if (count($state_select) >= 81)
                    {
                        $this->info('[ok]');

                        foreach ($state_select as $state)
                        {
                            $il = $state['#text'][0];

                            $this->line('######################################## '.$il.' ilçeleri alınıyor.');

                            $ilceler = $this->ilceListesi($turkiye_kodu, $state['value']);

                            if ($ilceler)
                            {
                                $this->info('[ok]');
                                
                                foreach ($ilceler as $ilce)
                                {
                                    $this->line('#-> '.$ilce->IlceAdi.' bağlanılıyor.');

                                    $vakitler = $this->vakitler($ilce->IlceID);

                                    if ($vakitler)
                                    {
                                        $this->info('[ok]');

                                        Redis::set("ezan:$il:$ilce->IlceAdi", json_encode($vakitler));
                                    }
                                    else
                                        $this->error('[failed]');
                                }
                            }
                            else
                                $this->error('[failed]');
                        }
                    }
                    else
                        $this->error('[failed]');
                }
                else
                    $this->error('[failed]');
            }
            else
                $this->error('[failed]');
        }
        else
            $this->error('Diyanet ana sayfasına bağlanılamadı. #1');
    }

    private function ilceListesi(int $country_id, int $state_id)
    {
        try
        {
            $end_point = $this->base_url.'/home/GetRegList';
            $query = Arr::query([
                'ChangeType' => 'state',
                'CountryId' => $country_id,
                'Culture' => 'tr-TR',
                'StateId' => $state_id,
            ]);

            $http = Http::get("$end_point?$query");

            return $http->successful() ? $http->object()?->StateRegionList : null;
        }
        catch (\Exception $e)
        {
            print_r($e->getMessage());
        }
    }

    private function vakitler(int $id)
    {
        try
        {
            $http = Http::get($this->base_url.'/'.$id);

            if ($http->successful())
            {
                $saw = new nokogiri($http->body());
                $table = @$saw->get('#tab-1 .vakit-table')->toText();
                $table = str_replace(PHP_EOL, '___', $table);
                $table = preg_replace([ '/\s{2,}/' ], '', trim($table));
                $table = explode('___', $table);

                $data = [];
                $key = 0;

                foreach ($table as $item)
                {
                    if ($item)
                        $data[$key][] = $item;
                    else
                        $key++;
                }

                $data = array_values($data);

                if (count($data) > 1)
                {
                    unset($data[0]);
                    unset($data[1]);

                    $months = [
                        'Ocak' => 1,
                        'Şubat' => 2,
                        'Mart' => 3,
                        'Nisan' => 4,
                        'Mayıs' => 5,
                        'Haziran' => 6,
                        'Temmuz' => 7,
                        'Ağustos' => 8,
                        'Eylül' => 9,
                        'Ekim' => 10,
                        'Kasım' => 11,
                        'Aralık' => 12,
                        ' ' => '-',
                    ];

                    $vakitler = [
                        'İmsak',
                        'Güneş',
                        'Öğle',
                        'İkindi',
                        'Akşam',
                        'Yatsı',
                    ];

                    $collection = [];

                    foreach ($data as $key => $day)
                    {
                        $date = substr(str_replace(
                            array_keys($months),
                            array_values($months),
                            $day[0]), 0, 10);

                        unset($day[0]);

                        $collection[$date] = array_combine($vakitler, $day);
                    }

                    // $collection = collect($data);
                    // $data = $collection->keyBy('0');

                    return $collection;
                }
                else
                    return false;
            }
            else
                return false;
        }
        catch (\Exception $e)
        {
            print_r($e->getMessage());
        }
    }
}
