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

// Route::get('/', function () {
//     return view('index');
// });

Auth::routes();

Route::get('/', 'CompositionController@home');
Route::get('/compositions', 'CompositionController@index');
Route::get('/compositions/{id}', 'CompositionController@show');
Route::get('/compositions/{id}/edit', 'CompositionController@edit');
Route::put('/compositions/{id}', 'CompositionController@update');
Route::delete('/compositions/{id}', 'CompositionController@destroy');
Route::post('/compositions', 'CompositionController@store');