<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Jobs\NewsTakerJob;

class NewsTaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:taker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Haber verilerini toplar.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $news = News::where('status', 'wait')->get();

        if (!count($news))
        {
            $this->error('Toplanacak haber bulunamadı.');

            return false;
        }

        foreach ($news as $item)
        {
            $this->info($item->url);
            $item->update([ 'status' => 'called' ]);

            NewsTakerJob::dispatch($item)->onQueue('news-taker');
        }
    }
}
