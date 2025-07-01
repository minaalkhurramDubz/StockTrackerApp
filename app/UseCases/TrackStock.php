<?php

namespace App\UseCases;

use App\Clients\StockStatus;
use App\Models\History;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TrackStock implements ShouldQueue
{
    use Dispatchable;

    protected Stock $stock;

    protected StockStatus $status;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function handle()
    {
        $this->checkAvailability();
        $this->notifyUser();
        $this->refreshstock();
        $this->recordToHistory();

    }

    // check availability
    protected function checkAvailability()
    {
        // make a new client ansd then call check availibility on it

        $this->status = $this->stock->retailer->client()->checkAvailability($this->stock);
    }

    // notify user
    protected function notifyUser()
    {

        // // trigger event notification
        if (! $this->stock->in_stock && $this->status->available) {
            User::first()->notify(new ImportantStockUpdate($this->stock));
        }
    }

    // update local stock
    protected function refreshstock()
    {

        $this->stock->update([
            'in_stock' => $this->status->available,  // Correct array access
            'price' => $this->status->price,      // Correct array access
        ]);
    }
    // record history

    protected function recordToHistory()
    {

        History::create(
            [

                'price' => $this->stock->price,
                'in_stock' => $this->stock->in_stock,
                'stock_id' => $this->stock->id,
                'product_id' => $this->stock->product_id,
            ]

        );

    }
}
