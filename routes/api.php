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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => 'cors'], function(){
    //aqui van todas las rutas que necesitan CORS

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');


Route::get('ajaxdata/getpostsdata',   'postsController@create')->name('ajaxdata.getpostsdata');

Route::post('ajaxdata/postpostsdata', 'postsController@store')->name('ajaxdata.postpostsdata');

Route::get('ajaxdata/fetchpostsdata', 'postsController@edit')->name('ajaxdata.fetchpostsdata');

Route::get('ajaxdata/removepostsdata', 'postsController@destroy')->name('ajaxdata.removepostsdata');


});