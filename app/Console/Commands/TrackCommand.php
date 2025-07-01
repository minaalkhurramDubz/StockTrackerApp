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
        // the model product tracks each record
        Product::all()->each->track();

    }
}
