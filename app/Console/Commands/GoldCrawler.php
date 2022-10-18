<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use nokogiri;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GoldCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:gold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Altın verilerini çeker.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $http = Http::get('https://bigpara.hurriyet.com.tr/altin/');
        $saw = new nokogiri($http->body());

        $table = $saw->get('.pgAltin .tableBox')->toText();
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
            print_r($data);
        }
        else
            $this->error('hata');

        exit;

        $title_raw = isset($table[0]['div'][0]['ul'][0]['li']);
        $items_raw = @$table[0]['div'][1]['ul'];

        if ($title_raw)
        {
            $titles = array_filter(array_map(function($item) {
                return @$item['#text'][0];
            }, $title_raw));

            if (count($titles) == 5)
            {
                $items = array_map(function($item) {
                    if (@count($item['li']) == 5)
                    {
                        return array_values(array_filter(array_map(function($item) {
                            return Str::contains($item, ['cell']) || Str::startsWith($item, '/') ? false : trim($item);
                        }, Arr::flatten($item['li']))));
                    }
                    else
                        return null;
                }, $items_raw);

                print_r([
                    'titles' => $titles,
                    'data' => $items
                ]);
            }
            else
                $this->error('Başlık sayısı eksik #2');
        }
        else
            $this->error('Hürriyet bigpara sitesinden altın için tablonun başlıkları alınamadı. #1');
    }
}
