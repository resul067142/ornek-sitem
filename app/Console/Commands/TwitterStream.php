<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\TwitterTrack;
use App\Models\TwitterToken;

use App\Jobs\TwitterStreamJob;

class TwitterStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:stream {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twitter\'dan stream başlatır.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->option('type'))
        {
            // kelime üzerinden bir stream başlat
            case 'track':
                /**
                 * Twitter Track tablosu twitter'dan toplanacak veri kriterlerini tutar.
                 * Bu case içerisinde ise sadece kelimeleri takip edeceğiz.
                 */
                $chunks = TwitterTrack::where('type', 'keyword')->get()
                    ->chunk(3); // chunk ile kelimeleri 3'erli hale getirdik.

                foreach ($chunks as $chunk) // chunkları döngüye aldık.
                {
                    /**
                     * Twitter'ın bizden istediği formatta kelimeleri verdik.
                     */
                    $params = [
                        'track' => implode( // implode ile dize'yi aralarında virgül olacak hale getirdik.
                            ',', // <-----
                            $chunk->pluck('value')->toArray() // chunklar halinde aldığımız kelime listesini, sadece value değeri yani kelime değeri olacak şekilde çıktı verdik.
                        ),
                        // 'language' => 'tr',
                    ];

                    print_r($params); // neler olduğunu ekrana bastık

                    $this->info('Yukarıdaki parametrelerle bir akış başlatıldı.');

                    /**
                     * Her şey hazır, ancak bir de token ihtiyacımız var.
                     * Bunun için de, aktif olarak kullanılmayan bir token çağırdık.
                     */
                    $token = TwitterToken::whereNull('stream_type')->first();

                    if ($token)
                    {
                        // boş olarak aldığımız token'ı kullandığımız belirttik.
                        $token->stream_type = 'track';
                        $token->stream_params = $params;
                        $token->created_at = now();
                        $token->save();

                        // token ve yukarıdaki parametrelerle bir job başlattık.
                        TwitterStreamJob::dispatch($token)->onQueue('twitter-stream');
                    }

                    echo PHP_EOL;
                }
            break;
            case 'follow':
            case 'location':

            break;
        }
    }
}
