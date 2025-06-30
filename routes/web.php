<?php

use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');

$user = User::factory()->create();
    return (new ImportantStockUpdate(Stock::first()))->toMail($user);

});
