<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Alaouy\Youtube\Facades\Youtube;

class YouTubeVideoSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:video:search {--keyword=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Youtube üzerinden video arar.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $results = Youtube::search($this->option('keyword'), 100);

        print_r($results);
    }
}
