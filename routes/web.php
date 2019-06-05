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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Admin Routes
Route::group( ['middleware' => 'auth' ], function() {
Route::get('/all-products', 'ProductController@index');
Route::get('/all-products/create', 'ProductController@create');
Route::post('/getItemData', 'ProductController@getItemData');
Route::post('/all-products/store', 'ProductController@store')->name('itemStore');
Route::post('/all-products/update', 'ProductController@update')->name('itemUpdate');
Route::get('/all-products/{id}/edit', 'ProductController@edit');
Route::get('/all-products/delete/{id}', 'ProductController@destroy');
});