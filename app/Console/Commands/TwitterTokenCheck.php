<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\TwitterToken;

class TwitterTokenCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:token:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Askıda kalan tokenları resetle.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $items = TwitterToken::get();

        foreach ($items as $token)
        {
            /**
             * Token 1 saatten eski ise veya güncelleme tarihi 2 dakikadan eski ise sonlandır.
             */
            if ($token->created_at <= date('Y-m-d H:i:s', strtotime('-1 hour')) || $token->updated_at <= date('Y-m-d H:i:s', strtotime('-2 minutes')))
            {
                posix_kill($token->pid);

                // Process sonlandırıldıktan sonra yeniden başlat.
                TwitterStreamJob::dispatch($token)->onQueue('twitter-stream');
            }
        }
    }
}
