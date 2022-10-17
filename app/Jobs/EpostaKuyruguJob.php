<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Uyeler;
use Mail;

class EpostaKuyruguJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uye;
    protected $eposta_sablonu;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Uyeler $uye, $eposta_sablonu)
    {
        $this->uye = $uye;
        $this->eposta_sablonu = $eposta_sablonu;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->uye)
            // ->locale($this->uye->dil)
            ->send($this->eposta_sablonu);
    }
}
