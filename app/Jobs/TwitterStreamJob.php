<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

use App\Models\TwitterToken;
use App\Models\Tweet;

class TwitterStreamJob implements ShouldQueue, ShouldBeUnique // ShouldBeUnique sınıfıyla bu kuyruğu benzersiz kuyruk olarak çalıştırmaya olanak tanıdık.
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TwitterToken $token)
    {
        $this->token = $token;
    }

    /**
     * Bu job'ın benzersiz olabilmesi için
     * benzersizliğini belirleyen bir benzersiz id olması gerekiyordu.
     * Biz de token değerinden aldığımız unique id'yi buraya tanımladık.
     */
    public function uniqueId()
    {
        return $this->token->id;
    }

    /**
     * Bu job kaç saniye boyunca unique değerini koruyacak.
     */
    public $uniqueFor = 3600;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Twitter stream servislerine istek atmadan önce
         * kendimizi twitter'a tanıtmak için bir header göndermemiz gerek.
         * Bu header için, hedef makinenin anlayacağı formatta bir yapı
         * hazırlayabilmek adına HandlerStack başlatıyoruz.
         */
        $stack = HandlerStack::create();

        /**
         * Stack'in içerisine oturum verilerini gönderdik.
         */
        $stack->push(
            new Oauth1(
                [
                    'consumer_key' => $this->token->consumer_key,
                    'consumer_secret' => $this->token->consumer_secret,
                    'token' => $this->token->token,
                    'token_secret' => $this->token->token_secret,
                ]
            )
        );

        /**
         * Ve bir tarayıcı açtık. Bir client.
         * Adres satırına gerekli sayfa ve bilgileri gönderdik.
         */
        $client = new Client(
            [
                'base_uri' => 'https://stream.twitter.com/1.1/',
                'handler' => $stack,
                'stream' => true,
                'auth' => 'oauth'
            ]
        );

        /**
         * Post methodu ile stream sayfasına isteğimiz attık.
         */
        $response = $client->post('statuses/filter.json', [
            // 'form_params' => [
            //     // 'track' => 'love,ankara,izmir,günaydın',
            //     // 'language' => 'tr',
            //     // 'locations' => '-180,-90,180,90',
            //     // 'follow' => '1723388599,1723453622,1723533356,1724536860'
            // ]
            'form_params' => $this->token->stream_params // istek kriterlerimiz
        ]);

        /**
         * Dönüşü aldık. Aldığımız dönüş sonsuz bir döngü içerisinde
         * veri gönderecektir bize.
         */
        $stream = $response->getBody();

        $chunk = []; // verileri toplu bir şekilde db'ye basmak için chunklar halinde tutmamız lazım.
        $chunk_count = 0; // sistemi yormamak için mevcut chunkta kaç veri olduğunu bir parametrede tutalım.

        /**
         * Twitter'dan gelen veriyi döngüye alıyoruz.
         */
        while (!$stream->eof())
        {
            /**
             * Her gelen bir kaç satırdan sonra oluşan tam bir json parametresini tanımlıyoruz.
             */
            $obj = json_decode($this->jsonLine($stream));

            /**
             * Gelen her veri Tweet olmayacağı için (uyarı mesajları da olacağı için)
             * Eğer id değeri taşıyorsa gelen obje, tweet olduğunu anlayalım.
             */
            if (@$obj->id)
            {
                /**
                 * Twitter'dan gelen desen içerisindeki değerlerden sadece
                 * işimize yarayacak olanları aldık.
                 * Tümünü görmek için print_r($obj) yazabilirsiniz.
                 */
                $chunk[$obj->id] = [
                    'tweet_id' => $obj->id,
                    'user_id' => $obj->user->id,
                    'user_title' => $obj->user->name,
                    'user_name' => $obj->user->screen_name,
                    'text' => $obj->text,
                    'publish_at' => $obj->created_at,
                ];

                $chunk_count++;

                /**
                 * Chunk istediğimiz sayıya ulaşınca, db insert işlemi yapıp
                 * mevcut chunk'ı boşaltalım.
                 */
                if ($chunk_count >= 10)
                {
                    /**
                     * Toplu bir şekilde bulk insert yaptık.
                     */
                    Tweet::upsert($chunk, ['tweet_id']);

                    /**
                     * Tokendan haberdar olabilmek için
                     * updated_at kolonu sürekli güncel tutulmalıdır.
                     * pid ise hangi processta çalıştığını görmem içindir.
                     */
                    $this->token->update([ 'updated_at' => now(), 'pid' => getmypid() ]);

                    $chunk = [];
                    $chunk_count = 0;
                }

                // echo $obj->user->screen_name.': '.$obj->text.PHP_EOL.PHP_EOL;
            }
            else
            {
                // print_r($obj);
            }
        }
    }

    /**
     * Gelen parça parça satırları tam bir json haline geldiğinde ekrana basar
     */
    private function jsonLine($stream, string $buffer = '', int $size = 0)
    {
        while (!$stream->eof())
        {
            if (false === ($byte = $stream->read(1)))
                return $buffer;

            $buffer .= $byte;

            if (++$size == null || substr($buffer, -strlen(PHP_EOL)) === PHP_EOL)
                break;
        }

        return $buffer;
    }
}
