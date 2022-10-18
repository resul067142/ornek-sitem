<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use nokogiri;
use Illuminate\Support\Arr;

class DepremCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:deprem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deprem verilerini toplar.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('http://www.koeri.boun.edu.tr/scripts/lst6.asp');

        if ($response->ok())
        {
            $data = [];

            $saw = new nokogiri($response->body());

            $pre = $saw->get('pre')->toText();

            preg_match_all("/(\d{4}\.\d{2}\.\d{2}.+)/", $pre, $matched);

            if (count($matched[0]))
            {
                $keys = [
                    'tarih',
                    'enlem',
                    'boylam',
                    'derinlik',
                    'md',
                    'ml',
                    'mw',
                    'yer',
                    'cozum',
                ];

                foreach($matched[0] as $line)
                {
                    $cols = preg_replace([ '/\s{2,}/' ], '_____', $line);
                    $cols = explode('_____', $cols);

                    if (count($cols) > 9)
                        unset($cols[count($cols) - 1]);

                    $item = array_combine($keys, $cols);

                    // if ($item['ml'] >= 5)
                    // {
                    //     $this->error('Büyük deprem');
                    //     print_r($item);
                    // }

                    $data[] = $item;
                }

                print_r(array_slice($data, 0, 5));
            }
            else
                $this->error('Deprem servisinde veri yok. #2');
        }
        else
            $this->error('Deprem servisine bağlanılamadı. #1');
    }
}
