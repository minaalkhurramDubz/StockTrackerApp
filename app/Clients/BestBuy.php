<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {

        $results = Http::get($this->endpoint($stock->sku))->json();

        // intercept the requests to see the results
        //

     


        $product = $results['products'][0] ?? [];

        return new StockStatus(
            $product['onlineAvailability'] ?? false,
            $this->dollarsToCents($product['salePrice'])
            // converting from dollars to cents
        );
    }

    protected function endpoint($sku)
    {
        $apiKey = config('services.clients.bestbuy.key');

        return "https://api.bestbuy.com/v1/products(sku={$sku})?apiKey={$apiKey}&format=json";
    }

    protected function dollarsToCents($amount)
    {
        return (int) ($amount * 100);

    }
}
