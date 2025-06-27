<?php

namespace Tests\Unit;

use App\Clients\ClientException;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProduct;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    /** @test */
    use RefreshDatabase;

    public function it_throws_an_exception_if_client_not_found_when_tracking()
    {
        // given i have a retialer with stock
        // if i track that stock but retialer doesnt have the client class for that stock ( non existent basically )
        // the function throws an exception
        $this->seed(RetailerWithProduct::class);

        Retailer::first()->update(['name' => 'Foo retialer ']);

        $this->expectException(ClientException::class);
        // track the stock
        Stock::first()->track();

    }
}
