<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UyelikDogrulamaKodu extends Mailable
{
    use Queueable, SerializesModels;

    protected $kod;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $kod)
    {
        $this->kod = $kod;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        file_put_contents('test.txt', 'calisti');
        return $this->markdown('eposta_sablonlari.uyelik_dogrulama_kodu', [
            'kod' => $this->kod
        ]);
    }
}
