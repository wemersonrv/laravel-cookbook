<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/charts', function () {
    $thisYearOrders = Order::query()
        ->whereYear('created_at', date('Y'))
        ->groupByMonth();

    $lastYearOrders = Order::query()
        ->whereYear('created_at', date('Y') -1)
        ->groupByMonth();

    return view('charts', [
      'thisYearOrders' => $thisYearOrders,
      'lastYearOrders' => $lastYearOrders,
    ]);
});
