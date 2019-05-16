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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'WelcomeController@index');

Route::prefix('players')->group(function() {
    Route::get('crawl', 'PlayerController@crawl');
    Route::get('build_binary', 'PlayerController@buildBinary');
    Route::post('restore/{id}', 'PlayerController@restore')->name('players.restore');
});

Route::resource('players', 'PlayerController');
