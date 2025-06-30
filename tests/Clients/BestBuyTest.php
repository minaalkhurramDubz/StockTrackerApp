<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Clients\Client;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Exception;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// if we use command like vendor/pin/phpunit --exclude-group-api , it will run all tests except the ones marked with this group
/** @group api */
class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product()
    {
        // given i have a product , with stock at best buy
        // if i use the best buy client to track that stock , it should return an appropriate stock status

        // seed the data
        $this->seed(RetailerWithProduct::class);

        $stock = tap(Stock::first())->update([
            'sku' => '6522225',
            // sku is taken from best buy website, this sku is for nintendo switch

            'url' => 'https://www.bestbuy.com/site/switch-with-neon-blue-and-neon-red-joycon-nintendo-switch/6522225.p?skuId=6522225',
        ]);

        try {
            $stockStatus = (new BestBuy)->checkAvailability($stock);
            dd($stockStatus);
        } catch (Exception $e) {
            $this->fail('failed to track any best buy api'.$e->getMessage());

        }

        $this->assertTrue(true);
    }

    /** @test  */

    // regression test for finding the bug
    public function it_creates_the_proper_stock_status_response()
    {

        Http::fake([
            '*' => Http::response([
                'products' => [
                    [
                        'salePrice' => 299.99,
                        'onlineAvailability' => true,
                    ],
                ],
            ], 200),
        ]);

        $stockStatus = (new BestBuy)->checkAvailability(new Stock);
        $this->assertEquals(29999, $stockStatus->price);
        $this->assertTrue($stockStatus->available);

    }
}
