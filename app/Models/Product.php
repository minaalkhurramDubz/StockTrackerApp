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

        // call back ,, when we are done tracking stock we will record it to history.
        $this->stock->each->track(
        );

    }

    public function history()
    {
        return $this->hasMany(History::class);

    }
}
