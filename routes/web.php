<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/products', 'ProductController@list')->name('productList');
Route::get('/product/{slug}', 'ProductController@details')->name('productDetails');
Route::get('/cart', 'CartController@cart')->name('cart');
Route::post('/addToCart', 'CartController@addToCart')->name('addToCart');
Route::post('/updateCart', 'CartController@updateCart')->name('updateCart');
Route::post('/deleteCartItem', 'CartController@deleteCart')->name('deleteCartItem');

