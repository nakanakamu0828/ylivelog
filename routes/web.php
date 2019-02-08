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

// Route::get('welcome', 'WelcomeController@index')->name('welcome');


// OAuth
Route::group(['middleware' => ['guest'], 'prefix' => 'oauth', 'as' => 'oauth.'], function () {
    Route::get('{provider}', [
            'as'   => 'redirector',
            'uses' => 'Auth\OAuthLoginController@redirector',
        ]
    )->where('provider', 'google');
    Route::get('callback/{provider}', 'Auth\OAuthLoginController@callback')->where('provider', 'google');
});

Route::group(['middleware' => 'auth', 'prefix' => 'video', 'as' => 'video.'], function () {
    Route::get('{id}/chat/download', 'Viede\ChatController@download')->name('chat.download');
    Route::get('{id}/user/download', 'Viede\UserController@download')->name('user.download');
});


// フロントエンドで画面遷移を行なう為、画面遷移はフロントエンドのVueRouterが制御する
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.+');

