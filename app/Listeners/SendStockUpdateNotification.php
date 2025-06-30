<?php

namespace App\Listeners;

use App\Events\NowInStock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;

class SendStockUpdateNotification
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NowInStock $event): void
    {
        //

        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
