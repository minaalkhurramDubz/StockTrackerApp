<?php

namespace App\Clients;

use App\Models\Stock;

interface Client
{
    // accessor function functionName(params): return type
    //
    public function checkAvailability(Stock $stock): StockStatus;
}
