<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    // ensures the database is reset between tests (fresh tables each time).
    use RefreshDatabase;

    /** @test */

    // test case is checking whether the track artisan command correctly handles and updates product stock
    public function it_tracks_product_stock()
    {

        // given - i have a product with stock

        $switch = Product::create(['name' => 'Nintendo Switch']);

        $best_buy = Retailer::create(['name' => 'Best Buy']);

        // we have no item yet so it shouldnt be in stock
        $this->assertFalse($switch->inStock());

        // add a new stxock
        $stock = new Stock(
            [
                'price' => 10000,
                'url' => 'https://foo.com',
                'sku' => '12345',
                'in_stock' => false,
            ]);

        $best_buy->addStock($switch, $stock);

        $this->assertFalse((bool) $stock->fresh()->in_stock);

        // when - trigger the php artisan track command

        $this->artisan('track');

        // then - the stock details should be refreshed
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
