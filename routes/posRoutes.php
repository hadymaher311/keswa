<?php

/**
 * Localization Group
 * 
 * @var string locale prefix nullable
 * @middleware to register locale
 * */
Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'en|ar'],
    'middleware' => 'LocalizationMiddleware'], function() {
    
    /**
     * All POS Controllers will be in POS Folder
     */
    Route::group(['namespace' => 'POS'],function(){


        /*********************************************** POS home page *******************************************/
        Route::get('/pos/home', 'HomeController@index')->name('pos.home');
        /*********************************************** POS home page *******************************************/

        /**
         * All POS Auth Controllers will be in POS\Auth Folder
         */
        Route::group(['namespace' => 'Auth'],function(){
            // get POS login page
            Route::GET('pos/login','LoginController@showLoginForm')->name('pos.login');
            // login with POS
            Route::POST('pos/login','LoginController@login');
            Route::post('pos/logout', 'LoginController@logout')->name('pos.logout');
            // send email for POS to change password
            Route::POST('pos/password/email','ForgotPasswordController@sendResetLinkEmail')->name('pos.password.email');
            // show page of POS to write his email to change password
            Route::GET('pos/password/reset','ForgotPasswordController@showLinkRequestForm')->name('pos.password.request');
            // reset POS password
            Route::POST('pos/password/reset','ResetPasswordController@reset');
            // get page where POS reset password
            Route::GET('pos/password/reset/{token}','ResetPasswordController@showResetForm')->name('pos.password.reset');
        });
    });
});