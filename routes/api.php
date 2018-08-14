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

Route::prefix('v1')->namespace('Api')->group(function () {
  Route::post('auth/login', 'AuthController@login');
  Route::post('auth/register', 'AuthController@register');
  Route::post('auth/password', 'AuthController@resetPassword');
  Route::get('teste', 'AuthorController@teste');
  Route::middleware('MonadaAuth')->group(function (){
    
    Route::post('publication/store','PublicationController@store');
    
    Route::post('user/follow','UserController@follow');
    Route::delete('user/unfollow/{id}','UserController@unfollow')->where('id', '[0-9]+');
    
    Route::get('author/search/{filter}/{offset}','AuthorController@search')->where('offset', '[0-9]+');
    Route::get('author/suggestion/{offset}','AuthorController@suggestion')->where('offset', '[0-9]+');
    
    Route::post('auth/logout','AuthController@logout');
  });
});

Route::get('/compositions', 'CompositionController@index');
Route::get('/compositions/{id}', 'CompositionController@show');
Route::get('/compositions/{id}/edit', 'CompositionController@edit');
Route::put('/compositions/{id}', 'CompositionController@update');
Route::delete('/compositions/{id}', 'CompositionController@destroy');
Route::post('/compositions', 'CompositionController@store');