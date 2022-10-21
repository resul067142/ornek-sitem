<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

use NotificationChannels\Telegram\TelegramUpdates;

use App\Notifications\TelegramDogrulamaKodu;

use App\Models\Uyeler;

class TelegramHelloWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:hello:world';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $uye = Uyeler::find(1038);

        if ($uye->telegram_chat_id)
        {
            $mesaj = $this->ask('Mesajınızı girin:');

            // Notification::send($uye, new TelegramDogrulamaKodu());
            $uye->notify((new TelegramDogrulamaKodu($mesaj))->onQueue('notifications'));
        }
        else
            $this->info('Bu kullanıcı telegram bağlantısı yapmamış.');
    }
}
