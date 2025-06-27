<?php

namespace App\Clients;

class StockStatus
{
    // declaring varaibles
    public $available;

    public $price;

    // class constructor

    public function __construct($available, $price)
    {
        $this->available = $available;
        $this->price = $price;

    }
}
