<?php

namespace App\Clients;

use App\Models\Stock;

interface Client
{
    // accessor function functionName(params): return type
    //
    public function checkAvailibility(Stock $stock): StockStatus;
}
