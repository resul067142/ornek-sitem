<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Events\MerhabaDunyaEvent;
use App\Models\Uyeler;

class HelloWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world {--mesaj=} {--user_id=}';

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
        $user = Uyeler::find($this->option('user_id'));

        event(new MerhabaDunyaEvent([
            'key' => $user->key,
            'mesaj' => $this->option('mesaj')
        ]));
    }
}
