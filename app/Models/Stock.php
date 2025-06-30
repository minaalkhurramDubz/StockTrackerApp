<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // not required unless table name has been changed
    protected $table = 'stocks';

    protected $casts = [
        'in_stock' => 'boolean',
    ];
    //

    public function track()
    {
        // hit an api endpoint for the associated retailer
        // fetch up to date data

        // using facotry pattenr to initialize new clients

        // make a new client ansd then call check availibility on it

        $status = $this->retailer->client()->checkAvailability($this);

        $this->update([
            'in_stock' => $status->available,  // Correct array access
            'price' => $status->price,      // Correct array access
        ]);

        // creating history for the product for testing
        $this->recordhistory();

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);

    }

    public function recordHistory()
    {
        $this->history()->create(
            [

                'price' => $this->price,
                'in_stock' => $this->in_stock,
                'product_id' => $this->product_id,
                //    'stock_id' => $this->id,
            ]

        );

    }
}
