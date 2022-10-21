<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

use NotificationChannels\Telegram\TelegramUpdates;

use App\Notifications\TelegramDogrulamaKodu;

use App\Models\Uyeler;

class TelegramChatIdDogrulama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:chat_id_dogrulama';

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

        if ($uye->telegram_chat_id && $this->confirm('Bu hesap zaten bağlanmış. Tekrar bağlamak istiyor musunuz?'))
        {
            $kod = rand(1000, 9999);

            $uye->telegram_verification_code = $kod;

            $this->table(
                [ 'Kod' ],
                [
                    [ $kod ]
                ]
            );

            $this->info('Yukarıdaki kod /OrnekSitem_bot telegram botuna yazın.');

            $confirm = $this->confirm('Kodu yazdınız mı?');

            // Notification::route('telegram', 'TELEGRAM_CHAT_ID')
            //             ->notify(new TelegramDogrulamaKodu());

            if ($confirm)
            {
                $updates = TelegramUpdates::create()
                    ->latest()
                    ->limit(10)
                    ->get();

                if ($updates['ok'])
                {
                    $chatId = @$updates['result'][0]['message']['chat']['id'];
                    $text = @$updates['result'][0]['message']['text'];

                    if ($text == $kod)
                    {
                        $uye->telegram_chat_id = $chatId;

                        $this->info('Eşleme tamam');
                    }
                    else
                        $this->error('Kod eşleşmedi');
                }

                $uye->save();
            }
            else
                $this->error('Onay verilmedi.');
        }
        else
            $this->info('İşlem geçildi.');
    }
}
