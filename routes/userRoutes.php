<?php

/**
 * Localization Group
 * 
 * @var locale prefix nullable
 * @middleware to register locale
 * */ 
Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'en|ar'],
    'middleware' => 'LocalizationMiddleware'], function() {
    
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes(['verify' => true]);

    /**
     * All User Controllers will be in User Folder
     */
    Route::group(['namespace' => 'User'],function(){
        Route::get('/home', 'HomeController@index')->name('home');
    });
});