<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// this class extends the local model
class Product extends Model
{
    public function inStock()
    {
        // find the product with the id (check if product is in stock basically  )
        return $this->stock()->where('in_stock', true)->exists();

    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function track()
    {

        $this->stock->each->track(
            fn ($stock) => $this->recordHistory($stock));

    }

    public function history()
    {
        return $this->hasMany(History::class);

    }

    public function recordHistory(Stock $stock)
    {
        $this->history()->create(
            [

                'price' => $stock->price,
                'in_stock' => $stock->in_stock,
                'stock_id' => $stock->id,
                //    'stock_id' => $this->id,
            ]

        );

    }
}
