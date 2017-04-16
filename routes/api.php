<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/dashboard', 'Api\DashboardController@statisticPanel');

Route::get('/products', 'Api\ProductController@index')->name('api.product.listing');
Route::get('/product/{id}', 'Api\ProductController@show');
Route::post('/products', 'Api\ProductController@create');
Route::patch('/product/{id}', 'Api\ProductController@update');
Route::delete('/product/{id}', 'Api\ProductController@delete');

Route::get('/orders', 'Api\OrderController@index')->name('api.order.listing');
Route::get('/order/{id}', 'Api\OrderController@show');
Route::post('/orders', 'Api\OrderController@create');
Route::patch('/order/{id}', 'Api\OrderController@update');
Route::delete('/order/{id}', 'Api\OrderController@delete');

Route::get('/address/{id}', 'Api\AddressController@show');
Route::post('/addresses', 'Api\AddressController@create');
Route::patch('/address/{id}', 'Api\AddressController@update');
Route::delete('/address/{id}', 'Api\AddressController@delete');

Route::get('/customers', 'Api\CustomerController@index')->name('api.customer.listing');
Route::get('/customer/{id}', 'Api\CustomerController@show');
Route::post('/customers', 'Api\CustomerController@create');
Route::patch('/customer/{id}', 'Api\CustomerController@update');
Route::delete('/customer/{id}', 'Api\CustomerController@delete');