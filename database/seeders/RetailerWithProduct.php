<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class RetailerWithProduct extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Given - i have a product with stock

        $switch = Product::create(['name' => 'Nintendo Switch']);

        $best_buy = Retailer::create(['name' => 'Best Buy']);

        // Add a new stock
        $best_buy->addStock($switch, new Stock([
            'price' => 10000,
            'url' => 'https://foo.com',
            'sku' => '12345',
            'in_stock' => false,
        ]));

        User::factory()->create([
            'email' => 'minaal.khurram@dubizzlelabs.com',
        ]);
    }
}
