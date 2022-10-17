<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TarihiGunYaz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarih:gun_yaz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ekrana sadece günü yazdırır.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(date('d'));
    }
}
