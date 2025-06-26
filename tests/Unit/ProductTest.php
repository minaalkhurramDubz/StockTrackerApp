<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
@test
     */
    public function it_checks_stock_for_products_at_retailers(): void
    {

        $switch = Product::create(['name' => 'Nintendo Switch']);

        $best_buy = Retailer::create(['name' => 'Best Buy']);

        // we have no item yet so it shouldnt be in stock
        $this->assertFalse($switch->inStock());

        // add a new stock
        $stock = new Stock(
            [
                'price' => 10000,
                'url' => 'https://foo.com',
                'sku' => '12345',
                'in_stock' => true,
            ]);

        $best_buy->addStock($switch, $stock);

        // after stock is added check on it, the assert should be true for successfully added stocks
        $this->assertTrue($switch->inStock());

    }
}
