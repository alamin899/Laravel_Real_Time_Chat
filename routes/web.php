<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});
Route::group(['namespace' => 'Backend','middleware' => 'auth'],function ()
{
    //user
    Route::get('/users','UserController@index')->name('user.index');

    //message
    Route::get('/message/{user_id}','MessageController@index')->name('message.index');
    Route::post('/message/store','MessageController@store')->name('message.store');
    Route::delete('/message/{message}','MessageController@singleMessageDestroy')->name('single-message.destroy');
    Route::delete('/message/{user_id}/all','MessageController@allMessageDestroy')->name('all-message.destroy');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
