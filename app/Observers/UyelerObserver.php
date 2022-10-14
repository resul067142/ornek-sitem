<?php

namespace App\Observers;

use App\Models\Uyeler;

use Illuminate\Support\Facades\Redis;

class UyelerObserver
{
    /**
     * Handle the Uyeler "created" event.
     *
     * @param  \App\Models\Uyeler  $uyeler
     * @return void
     */
    public function created(Uyeler $uyeler)
    {
        Redis::set("uyeler:oturum:$uyeler->token", $uyeler->id);
    }

    /**
     * Handle the Uyeler "updated" event.
     *
     * @param  \App\Models\Uyeler  $uyeler
     * @return void
     */
    public function updated(Uyeler $uyeler)
    {
        $old_token = $uyeler->getOriginal('token');

        if ($uyeler->isDirty('token'))
        {
            Redis::del("uyeler:oturum:$old_token");
            Redis::set("uyeler:oturum:$uyeler->token", $uyeler->id, 'EX', 600);
        }
    }

    /**
     * Handle the Uyeler "deleted" event.
     *
     * @param  \App\Models\Uyeler  $uyeler
     * @return void
     */
    public function deleted(Uyeler $uyeler)
    {
        Redis::del("uyeler:oturum:$uyeler->token");
    }

    /**
     * Handle the Uyeler "restored" event.
     *
     * @param  \App\Models\Uyeler  $uyeler
     * @return void
     */
    public function restored(Uyeler $uyeler)
    {
        //
    }

    /**
     * Handle the Uyeler "force deleted" event.
     *
     * @param  \App\Models\Uyeler  $uyeler
     * @return void
     */
    public function forceDeleted(Uyeler $uyeler)
    {
        //
    }
}
