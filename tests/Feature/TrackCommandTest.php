<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    // ensures the database is reset between tests (fresh tables each time).
    use RefreshDatabase;

    /** @test */

    // test case is checking whether the track artisan command correctly handles and updates product stock
    public function it_tracks_product_stock()
    {

        $this->seed(RetailerWithProduct::class);

        $this->assertFalse(Product::first()->inStock());

        // faking an http endpoint
        Http::fake(function () {
            return [
                'available' => true,
                'price' => 2000,
            ];
        });

        

        // dd(Product::all());
        // when - trigger the php artisan track command

        $this->artisan('track');

        // then - the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }
}
