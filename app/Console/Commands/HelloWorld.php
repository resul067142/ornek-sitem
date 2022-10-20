<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Events\MerhabaDunyaEvent;

class HelloWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world {--mesaj=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push etkinliklerine mesaj gönderir.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        event(new MerhabaDunyaEvent($this->option('mesaj')));
    }
}
