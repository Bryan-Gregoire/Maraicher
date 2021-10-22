<?php

use App\Http\Controllers\OfferController;
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

Route::get('/offers', function () {
    return view('offers.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::resource('offers', OfferController::class);
Route::get('/my', [OfferController::class, 'index_personal'])->name('offers.myOffers');



