<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('restaurants', 'RestaurantController@index');
Route::get('categories', "CategoryController@index");
Route::get('dishes','DishController@index');
Route::post('orders', 'OrderController@store');
Route::get('orders', 'Walfood\OrderController@show');
Route::post('checkout', 'CheckoutController@pay');
Route::get('statistics/{slug}', 'Walfood\OrderController@statistiche');

// Route::middleware(['cors'])->group(function () {
//     Route::post('orders', 'OrderController@store');
// });
