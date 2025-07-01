<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'track all product stock ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // fetch all products for progress bar
        $products = Product::all();

        // start a progress bar for feedback , initializes by the number of products
        $this->output->progressStart($products->count());

        // the model product tracks each record
        $products->each(function ($products) {
            $products->track();

            $this->output->progressAdvance();
        });

        // finsih bar and shopw results in table
        //
        $this->showResults();

    }

    protected function showResults()
    {
        // finsih progress bar to 100%
        $this->output->progressFinish();

        $data = Product::leftJoin('stocks', 'stocks.product_id', '=', 'products.id')
            ->get(['name', 'price', 'url', 'in_stock']);

        $this->table(

            // headers
            ['Name', 'Price', 'URL', 'IN stock'],
            $data
        );
    }
}
