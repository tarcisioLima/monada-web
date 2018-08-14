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

Auth::routes();

//O PULO DO GATO PRA FAZER O ROTEAMENTO DA SPA FUNFAR
Route::get('/{any}', 'SPAController@index')->where('any', '.*');



//ROTA PARA RECUPERAR EMAIL, CÊ QUE MANDA BRUXÃO!!! Lá na API estou enviando a rota /reset-password/{token}
//Route::get('/reset-password/{token}', 'SeQuemanda@bruxao');