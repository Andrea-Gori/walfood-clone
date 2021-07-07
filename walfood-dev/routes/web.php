<?php

use Illuminate\Support\Facades\Auth;
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
// ROTTE GUEST
//// Rotta homepage (ricerca ristoranti)
Route::get('/', 'HomeController@index')->name('home');
Route::get('buy', 'HomeController@buy')->name('buy');
Route::get('/restaurants/{slug}', 'RestaurantController@show')->name('frontoffice.restaurants.show');
Route::get('buy/{slug}', 'HomeController@buy')->name('buy');
Route::get('checkout', 'CheckoutController@index')->name('checkout.index');
Route::post('checkout/pay', 'CheckoutController@pay')->name('checkout.pay');
// - API ricerca ristoranti in api.php
// - CRUD Ordini/Carrello (resource)
// - Checkout


Auth::routes();
//ROTTE USER REGISTRATO
Route::prefix('walfood')
    ->namespace('Walfood')
    ->middleware('auth')
    ->name('walfood.')
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('dashboard');
        Route::resource('categories', 'CategoryController');
        Route::resource('restaurants', 'RestaurantController');
        Route::resource('dishes', 'DishController');
        Route::post('piatti', 'DishController@getRestaurant')->name('getrestaurant');
        Route::get('restaurants/{slug}', 'RestaurantController@show')->name('restaurants.show');
        Route::get('orders/{slug}', 'OrderController@index')->name('statistics.index');
        Route::get('statistiche', 'OrderController@statistiche')->name('statistics.graph');
        //inserire qui le resources per i crud:
        // - DISH
        // - API x statistica in api.php
    });
