<?php

namespace App\Clients;

use App\Models\Retailer;
use Str;

// client facctoyr using factory pattenrn
class ClientFactory
{
    // makes the retailer based on the retailer name , ex best buy , target etc x
    public function make(Retailer $retailer): Client
    {

        $class = 'App\\Clients\\'.Str::studly($retailer->name);

        if (! class_exists($class)) {
            throw new ClientException('Client not found for : '.$retailer->name);
        }

        // return the instance of the client class
        return new $class;

    }
}
