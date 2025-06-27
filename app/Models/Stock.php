<?php

namespace App\Models;

use App\Clients\BestBuy;
use App\Clients\ClientException;
use Facades\App\Clients\ClientFactory;
use App\Clients\Target;
use Illuminate\Database\Eloquent\Model;
use Str;

class Stock extends Model
{
    // not required unless table name has been changed
    protected $table = 'stocks';

    protected $casts = [
        'in_stock' => 'boolean',
    ];

    public function track()
    {
        // hit an api endpoint for the associated retailer
        // fetch up to date data

        //using facotry pattenr to initialize new clients 

        // make a new client and then call check availibility on it 

        $status=$this->retailer->client()->checkAvailibility($this);
   
        $this->update([
            'in_stock' => $status->available,  // Correct array access
            'price' => $status->price,      // Correct array access
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
