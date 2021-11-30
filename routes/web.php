<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::resource('offers', OfferController::class)->middleware(['auth']);
Route::resource('sales', SaleController::class)->middleware(['auth']);
Route::resource('reservations', ReservationController::class)->middleware(['auth']);
Route::post('/reservations/confirm', [ReservationController::class, 'selectUser'])
    ->name('reservations.select')->middleware(['auth']);
require __DIR__ . '/auth.php';

Route::get('/my', [OfferController::class, 'index_personal'])->middleware(['auth'])->name('offers.myOffers');
Route::get('/mySales', [SaleController::class, 'index'])->middleware(['auth'])->name('sales.my');
Route::post('/search', [OfferController::class, 'search'])->middleware(['auth'])->name('search_bar');



