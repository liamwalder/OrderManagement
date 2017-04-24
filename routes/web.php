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

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/create', 'OrderController@create')->name('orders.create');
Route::get('/orders/edit/{id}', 'OrderController@edit')->name('orders.edit');

Route::get('/products', 'ProductController@index')->name('products.index');

Route::get('/customers', 'CustomerController@index')->name('customers.index');
