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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/youtube/livechats', 'Api\Youtube\LiveChatController@index')->name('youtube.livechats');

    Route::get('/videos', 'Api\VideoController@index')->name('video');
    Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
        Route::get('{id}', 'Api\VideoController@show')->name('show');
        Route::delete('{id}', 'Api\VideoController@destroy')->name('destroy');
        Route::get('{id}/chats', 'Api\Video\PostController@index')->name('chats');
    });
});