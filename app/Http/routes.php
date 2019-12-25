<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('items');
});

Route::get('/items', 'ItemController@index');
Route::post('/items/add', 'ItemController@store');
Route::delete('/items/remove/{itemId}', 'ItemController@destroy');
Route::delete('/items/remove-selected', 'ItemController@removeSelected');
Route::delete('/items/remove-all', 'ItemController@removeAll');