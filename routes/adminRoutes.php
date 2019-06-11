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
     * All Admin Controllers will be in Admin Folder
     */
    Route::group(['namespace' => 'Admin'],function(){


        // admin home page
        Route::get('/admin/home', 'HomeController@index')->name('admin.home');

        // Permissions CRUD routes
        Route::resource('/admin/permissions', 'PermissionsController');

        /**
         * All Admin Auth Controllers will be in Admin\Auth Folder
         */
        Route::group(['namespace' => 'Auth'],function(){
            // get admin login page
            Route::GET('admin/login','LoginController@showLoginForm')->name('admin.login');
            // login with admin
            Route::POST('admin/login','LoginController@login');
            Route::post('admin/logout', 'LoginController@logout')->name('admin.logout');
            // send email for admin to change password
            Route::POST('admin/password/email','ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
            // show page of admin to write his email to change password
            Route::GET('admin/password/reset','ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
            // reset admin password
            Route::POST('admin/password/reset','ResetPasswordController@reset');
            // get page where admin reset password
            Route::GET('admin/password/reset/{token}','ResetPasswordController@showResetForm')->name('admin.password.reset');
        });
    });
});