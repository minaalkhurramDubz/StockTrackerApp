<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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

        // strategy to hit the paerticular end point
        if ($this->retailer->name === 'Best Buy') {
            $results = Http::get('http://foo.test')->json();
            $this->update([
                'in_stock' => $results['available'],  // Correct array access
                'price' => $results['price'],         // Correct array access
            ]);
        }

        dd($results);

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
