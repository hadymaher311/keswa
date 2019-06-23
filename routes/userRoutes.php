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
    
        
    Auth::routes(['verify' => true]);
    
    /**
     * All User Controllers will be in User Folder
     */
    Route::group(['namespace' => 'User'],function(){
        // blocked user routes for auth only
        Route::group(['middleware' => ['auth', 'verified'],], function() {
            Route::get('/home', 'HomeController@index')->name('home');
        });
        Route::get('/', 'HomeController@welcome')->name('welcome');
    });
});