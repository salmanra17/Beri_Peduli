<?php

namespace App\Observers;

use App\Jobs\TranslateKampanye;
use App\Models\Kampanye;

class KampanyeObserver
{
    /**
     * Dispatch translation job when a campaign is created.
     */
    public function created(Kampanye $kampanye): void
    {
        TranslateKampanye::dispatch($kampanye)->delay(now()->addSeconds(5));
    }

    /**
     * Dispatch translation job when judul or deskripsi changes.
     */
    public function updated(Kampanye $kampanye): void
    {
        if ($kampanye->wasChanged(['judul', 'deskripsi'])) {
            TranslateKampanye::dispatch($kampanye)->delay(now()->addSeconds(5));
        }
    }
}
