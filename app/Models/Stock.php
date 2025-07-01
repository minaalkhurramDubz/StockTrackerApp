<?php

namespace App\Models;

use App\UseCases\TrackStock;
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

        // dispatching a job
        dispatch(new TrackStock($this));

        //    (new TrackStock($this))->handle();

        // hit an api endpoint for the associated retailer
        // fetch up to date data

        // using facotry pattenr to initialize new clients

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
