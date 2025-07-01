<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    // ensures the database is reset between tests (fresh tables each time).
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->seed(RetailerWithProduct::class);
    }

    /** @test */

    // test case is checking whether the track artisan command correctly handles and updates product stock
    public function it_tracks_product_stock()
    {

        $this->assertFalse(Product::first()->inStock());

        // faking an http endpoint
        // Http::fake(function () {
        //     return [
        //         'available' => true,
        //         'price' => 2000,
        //     ];
        // });

        Http::fake([
            '*' => Http::response([
                'products' => [
                    [
                        'onlineAvailability' => true,
                        'salePrice' => 299.99,
                    ],
                ],
            ]),
        ]);

        //  dd(Product::all());
        //    when - trigger the php artisan track command

        $this->artisan('track');

        // then - the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }
}
