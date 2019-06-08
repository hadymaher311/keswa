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


Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'en|ar'],
    'middleware' => 'LocalizationMiddleware'], function() {

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes(['verify' => true]);

    Route::get('/home', 'HomeController@index')->name('home');

});
