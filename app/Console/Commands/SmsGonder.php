<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Uyeler;

class SmsGonder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:gonder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'NETGSM üzerinden sms gönderir.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $uye = Uyeler::find(1038);

        if ($uye->sendSms('merhaba'))
            $this->info('Başarılı');
        else
            $this->error('Başarısız');
    }
}
