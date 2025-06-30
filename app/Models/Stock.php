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

    public function track($callback = null)
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

        // compact way to optionally run a callback if one is provided. (if callback is not null )
        $callback && $callback($this);

        // creating history for the product for testing
        //      $this->recordhistory();

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Retailer::class);
    }
}
