<?php

namespace Tests\Unit;


use App\Clients\StockStatus;
use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Facades\App\Clients\ClientFactory;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProductHistoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;

    /**
    @test
     */
    public function it_records_history_each_time_stock_is_tracked()
    {

        // given stock has a retailer
        // if i track it , new history should be creared

        $this->seed(RetailerWithProduct::class);



        ClientFactory::shouldReceive('make->checkAvailability')
        ->andReturn(new StockStatus($available = true, $price=99));

        // fake http to mock the request 
        // Http::fake([
        //     '*' => Http::response([
        //         'products' => [
        //             [
        //                 'salePrice' => 299.99,
        //                 'onlineAvailability' => true,
        //             ],
        //         ],
        //     ], 200),
        // ]);


        $product = tap(Product::first(), function ($product){


        $this->assertCount(0, $product->history);

        $product->track();

        $this->assertCount(1, $product->refresh()->history);
        });

        $history = $product->history->first();



        $stock= $product->stock[0];



        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);

    }
}
