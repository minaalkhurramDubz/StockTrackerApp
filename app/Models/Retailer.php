<?php

namespace App\Models;

use Facades\App\Clients\ClientFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    public function addStock(Product $product, Stock $stock)
    {
        // associates current product item with its id in db to update value of the stock
        $stock->product_id = $product->id;

        // it should add all attributes of stock to the model
        $this->stock()->save($stock);

    }

    // a retailer has stock

    public function stock()
    {
        // relationship with stock db, retailer has many stock
        return $this->hasMany(Stock::class);
    }


    // client creation. 
    public function client()
    {

        return ClientFactory::make($this);
    }
}
