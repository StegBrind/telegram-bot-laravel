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

Route::view('/', 'welcome');

Route::group(['namespace' => 'Backend', 'middleware' => 'auth', 'prefix' => 'setting'], function ()
{
    Route::view('/', 'setting')->name('setting');
    Route::post('apply', 'SettingController@makeChanges')->name('setting.apply');
    Route::get('show/webhook', 'SettingController@showWebhook')->name('show.webhook');
});

Route::post(\Telegram::getAccessToken(), 'TelegramController@webhook');

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');
