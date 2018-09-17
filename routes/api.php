<?php

use Illuminate\Http\Request;
use App\Utils\Obscure;

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
Route::bind('userId',            function ($id) { return Obscure::unuser($id)        ?? abort(404);});
Route::bind('authorId',          function ($id) { return Obscure::unauthor($id)      ?? abort(404);});
Route::bind('publicationId',     function ($id) { return Obscure::unpublication($id) ?? abort(404);});
Route::bind('folderId',          function ($id) { return Obscure::unfolder($id)      ?? abort(404);});
Route::bind('lastPublicationId', function ($id) { return Obscure::unpublication($id) ?? abort(404);});

Route::prefix('v1')->namespace('Api')->group(function (){
  Route::post('auth/login', 'AuthController@login');
  Route::post('auth/register', 'AuthController@register');
  Route::post('auth/password', 'AuthController@resetPassword');
  
  Route::post('test/store-system-notification', 'TestController@storeSystemNotification');
  Route::get('publication/store-olavo', 'PublicationController@storeOlavo');
  Route::get('test/teste', 'TestController@teste');
  
  Route::middleware('MonadaAuth')->group(function (){
    
    Route::get('publication/show/{offset?}/{lastPublicationId?}','PublicationController@show')->where('offset', '[0-9]+');
    Route::get('publication/highlights/{offset?}','PublicationController@highlights')->where('offset', '[0-9]+');
    Route::get('publication/search/{offset?}','PublicationController@search')->where('offset', '[0-9]+');
    Route::get('publication/categories','PublicationController@categories');
    
    Route::get('user/feed/{offset?}/{lastPublicationId?}','UserController@feed')->where('offset', '[0-9]+');
    Route::get('user/me', 'UserController@me');
    Route::put('user/update', 'UserController@update');
    Route::put('user/update-password', 'UserController@updatePassword');
    Route::get('user/profile/{userId}','UserController@profile');
    Route::get('user/liked/{offset?}','UserController@liked')->where('offset', '[0-9]+');
    Route::get('user/saved/{offset?}','UserController@saved')->where('offset', '[0-9]+');
    Route::post('user/follow','UserController@follow');
    Route::delete('user/unfollow/{userId}','UserController@unfollow');
    Route::put('user/mute/{userId}','UserController@mute');
    Route::put('user/unmute/{userId}','UserController@unmute');
    Route::get('user/author-to-feed','UserController@authorToFeed');
    Route::get('user/following/{offset?}','UserController@following')->where('offset', '[0-9]+');
    Route::delete('user/clear-unread-notification/{action}/{actionId?}','UserController@clearUnreadNotification')->where('action', '[A-Z]+');
    Route::post('user/like','UserController@like');
    Route::delete('user/unlike/{publicationId}','UserController@unlike');
    Route::post('user/save','UserController@save');
    Route::delete('user/unsave/{publicationId}','UserController@unsave');
    Route::post('user/store-image', 'UserController@storeImage');
    Route::get('user/notifications/{offset?}', 'UserController@notifications')->where('offset', '[0-9]+');
    Route::put('user/read-notifications', 'UserController@readNotifications');
    Route::get('user/list/{offset?}','UserController@list')->where('offset', '[0-9]+');
    
    Route::post('author/store','AuthorController@store');
    Route::get('author/{authorId}/publication/{offset?}/{lastPublicationId?}','AuthorController@publication')->where('offset', '[0-9]+');
    Route::get('author/{authorId}/folder/{folderId}/publication/{offset?}','AuthorController@publicationInFolder')->where('offset', '[0-9]+');
    Route::get('author/search/{filter}/{offset}','AuthorController@search')->where('offset', '[0-9]+');
    Route::get('author/suggestion/{offset}','AuthorController@suggestion')->where('offset', '[0-9]+');
    Route::get('author/{authorId}/folder','AuthorController@folder')->where('offset', '[0-9]+');
    
    Route::get('folder/show/{folderId?}','FolderController@show');
    Route::put('folder/update','FolderController@update');
    Route::post('folder/store','FolderController@store');
    Route::delete('folder/delete/{folderId}','FolderController@delete');
    
    Route::post('auth/logout','AuthController@logout');
  }); //ALL USERS AUTH
  
  Route::middleware('MonadaAuthorAuth')->group(function (){
    Route::post('publication/store','PublicationController@store');
    Route::put('publication/update','PublicationController@update');
    Route::post('publication/store-image','PublicationController@storeImage');
    Route::get('publication/link-metatag','PublicationController@linkMetatag');
    Route::delete('publication/delete/{publicationId}','PublicationController@delete');
    
    Route::get('folder/show/{folderId?}','FolderController@show');
    Route::put('folder/update','FolderController@update');
    Route::post('folder/store','FolderController@store');
    Route::delete('folder/delete/{folderId}','FolderController@delete');
  }); //ONLY USERS-AUTHOR AUTH
  
  Route::middleware('MonadaHybridAuth')->group(function (){
    Route::get('user/check-username/{username}', 'UserController@checkUsername');
    Route::get('user/check-email/{email}', 'UserController@checkEmail');
    Route::get('user/check-invite/{invite}', 'UserController@checkInvite');
  }); //ALL USERS AUTH AND NON-AUTH
  
});

Route::get('/compositions', 'CompositionController@index');
Route::get('/compositions/{id}', 'CompositionController@show');
Route::get('/compositions/{id}/edit', 'CompositionController@edit');
Route::put('/compositions/{id}', 'CompositionController@update');
Route::delete('/compositions/{id}', 'CompositionController@destroy');
Route::post('/compositions', 'CompositionController@store');