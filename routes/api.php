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
    Route::get('publication/show/{offset?}/{last?}','PublicationController@show')->where('offset', '[0-9]+')->where('last', '[0-9]+');
    Route::get('publication/highlights/{offset?}','PublicationController@highlights')->where('offset', '[0-9]+');
    Route::get('publication/search/{offset?}','PublicationController@search')->where('offset', '[0-9]+');
    Route::get('publication/categories','PublicationController@categories');
    
    Route::get('user/profile/{id}','UserController@profile')->where('id', '[0-9]+');
    Route::post('user/follow','UserController@follow');
    Route::delete('user/unfollow/{id}','UserController@unfollow')->where('id', '[0-9]+');
    Route::put('user/mute/{id}','UserController@mute')->where('id', '[0-9]+');
    Route::put('user/unmute/{id}','UserController@unmute')->where('id', '[0-9]+');
    Route::get('user/author-to-feed','UserController@authorToFeed');
    Route::get('user/following/{offset?}','UserController@following')->where('offset', '[0-9]+');
    Route::delete('user/clear-unread-notification/{action}/{actionId?}','UserController@clearUnreadNotification')->where('action', '[A-Z]+')->where('actionId', '[0-9]+');
    Route::post('user/like','UserController@like');
    Route::delete('user/unlike/{id}','UserController@unlike')->where('id', '[0-9]+');
    Route::post('user/save','UserController@save');
    Route::delete('user/unsave/{id}','UserController@unsave')->where('id', '[0-9]+');
    
    Route::get('author/{id}/publication/{offset?}/{last?}','AuthorController@publication')->where('offset', '[0-9]+')->where('id', '[0-9]+')->where('last', '[0-9]+');
    Route::get('author/{id}/folder/{folder}/publication/{offset?}','AuthorController@publicationInFolder')->where('offset', '[0-9]+')->where('id', '[0-9]+')->where('folder', '[0-9]+');
    Route::get('author/search/{filter}/{offset}','AuthorController@search')->where('offset', '[0-9]+');
    Route::get('author/suggestion/{offset}','AuthorController@suggestion')->where('offset', '[0-9]+');
    Route::get('author/folder/{id?}','AuthorController@folder')->where('offset', '[0-9]+');
    Route::get('author/profile-folders/{id}','AuthorController@profileFolders')->where('offset', '[0-9]+');
    
    Route::post('auth/logout','AuthController@logout');
  });
});

Route::get('/compositions', 'CompositionController@index');
Route::get('/compositions/{id}', 'CompositionController@show');
Route::get('/compositions/{id}/edit', 'CompositionController@edit');
Route::put('/compositions/{id}', 'CompositionController@update');
Route::delete('/compositions/{id}', 'CompositionController@destroy');
Route::post('/compositions', 'CompositionController@store');