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
        /*********************************************** POS home page *******************************************/
        
        /*********************************************** orders CRUD routes *******************************************/
        Route::get('/pos/pos_orders', 'OrdersController@index')->name('pos_orders.index');
        Route::get('/pos/pos_orders/create', 'OrdersController@create')->name('pos_orders.create');
        Route::get('/pos/pos_orders/{order}/show', 'OrdersController@show')->name('pos_orders.show');
        Route::get('/pos/pos_orders/{order}/edit', 'OrdersController@edit')->name('pos_orders.edit');
        Route::post('/pos/pos_orders', 'OrdersController@store')->name('pos_orders.store');
        Route::PUT('/pos/pos_orders/{order}/update', 'OrdersController@update')->name('pos_orders.update');
        Route::get('/pos/home', 'OrdersController@index')->name('pos.home');
        Route::delete('/pos/pos_orders', 'OrdersController@destroy')->name('pos_orders.destroy');
        Route::get('/pos/pos_orders/{order}/invoice', 'OrdersController@invoice')->name('pos_orders.invoice');
        Route::get('/pos/pos_orders/{order}/invoice/print', 'OrdersController@invoicePrint')->name('pos_orders.invoice.print');
        Route::get('/pos/pos_orders/{order}/approve', 'OrdersController@approveView')->name('pos_orders.approve');
        Route::post('/pos/pos_orders/{order}/complete', 'OrdersController@complete')->name('pos_orders.complete');
        /*********************************************** orders CRUD routes *******************************************/

        /*********************************************** POS profile pages *******************************************/
        Route::get('/pos/profile', 'ProfileController@index')->name('pos.profile');
        Route::get('/pos/profile/edit', 'ProfileController@edit')->name('pos.profile.edit');
        Route::put('/pos/profile/edit', 'ProfileController@update')->name('pos.profile.edit');
        Route::get('/pos/profile/edit/address', 'ProfileController@editAddress')->name('pos.profile.address.edit');
        Route::PUT('/pos/profile/edit/address', 'ProfileController@updateAddress')->name('pos.profile.address.edit');
        Route::get('/pos/profile/edit/password', 'ProfileController@editPassword')->name('pos.profile.edit.password');
        Route::PUT('/pos/profile/edit/password', 'ProfileController@updatePassword')->name('pos.profile.edit.password');
        Route::PUT('/pos/profile/edit/image', 'ProfileController@updateImage')->name('pos.profile.edit.image');
        Route::get('/pos/profile/settings', 'ProfileController@showSettings')->name('pos.profile.settings');
        Route::PUT('/pos/profile/edit/language', 'ProfileController@updateLanguage')->name('pos.profile.edit.language');
        /*********************************************** POS profile pages *******************************************/

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