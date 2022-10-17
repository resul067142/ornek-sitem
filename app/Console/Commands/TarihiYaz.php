<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TarihiYaz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarih:yaz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ekrana tarih yazdırır.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(date('Y-m-d H:i:s'));
    }
}
