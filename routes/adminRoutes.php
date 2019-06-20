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


        /*********************************************** admin home page *******************************************/
        Route::get('/admin/home', 'HomeController@index')->name('admin.home');
        /*********************************************** admin home page *******************************************/
        
        /*********************************************** Roles CRUD routes *******************************************/
        Route::resource('/admin/roles', 'RolesController');
        Route::delete('/admin/roles', 'RolesController@destroy')->name('roles.destroy');
        /*********************************************** Roles CRUD routes *******************************************/
        
        /*********************************************** permissions CRUD routes *******************************************/
        Route::resource('/admin/permissions', 'PermissionsController');
        Route::delete('/admin/permissions', 'PermissionsController@destroy')->name('permissions.destroy');
        /*********************************************** permissions CRUD routes *******************************************/
        
        /*********************************************** Admins CRUD routes *******************************************/
        Route::resource('/admin/admins', 'AdminsController');
        Route::delete('/admin/admins', 'AdminsController@destroy')->name('admins.destroy');
        Route::get('/admin/admins/{admin}/edit/password', 'AdminsController@editPassword')->name('admins.edit.password');
        Route::PUT('/admin/admins/{admin}/edit/password', 'AdminsController@updatePassword')->name('admins.edit.password');
        Route::PUT('/admin/admins/{admin}/active', 'AdminsController@active')->name('admins.active');
        /*********************************************** Admins CRUD routes *******************************************/
        
        /*********************************************** products CRUD routes *******************************************/
        Route::resource('/admin/products', 'ProductsController');
        Route::delete('/admin/products', 'ProductsController@destroy')->name('products.destroy');
        Route::PUT('/admin/products/{product}/active', 'ProductsController@active')->name('products.active');
        Route::PUT('/admin/products/{product}/allowreviews', 'ProductsController@allowReviews')->name('products.allow.reviews');
        Route::PUT('/admin/products/{product}/freeshipping', 'ProductsController@freeShipping')->name('products.free.shipping');
        /*********************************************** products CRUD routes *******************************************/
        
        /*********************************************** orders CRUD routes *******************************************/
        Route::resource('/admin/orders', 'OrdersController');
        Route::delete('/admin/orders', 'OrdersController@destroy')->name('orders.destroy');
        /*********************************************** orders CRUD routes *******************************************/
        
        /*********************************************** categories CRUD routes *******************************************/
        Route::resource('/admin/categories', 'CategoriesController');
        Route::delete('/admin/categories', 'CategoriesController@destroy')->name('categories.destroy');
        Route::PUT('/admin/categories/{category}/active', 'CategoriesController@active')->name('categories.active');
        Route::PUT('/admin/categories/{category}/visibility', 'CategoriesController@visibility')->name('categories.visibility');
        /*********************************************** categories CRUD routes *******************************************/
        
        /*********************************************** sub_categories CRUD routes *******************************************/
        Route::resource('/admin/sub_categories', 'SubCategoriesController');
        Route::delete('/admin/sub_categories', 'SubCategoriesController@destroy')->name('sub_categories.destroy');
        Route::PUT('/admin/sub_categories/{sub_category}/active', 'SubCategoriesController@active')->name('sub_categories.active');
        Route::PUT('/admin/sub_categories/{sub_category}/visibility', 'SubCategoriesController@visibility')->name('sub_categories.visibility');
        /*********************************************** sub_categories CRUD routes *******************************************/
        
        /*********************************************** sub_sub_categories CRUD routes *******************************************/
        Route::resource('/admin/sub_sub_categories', 'SubSubCategoriesController');
        Route::delete('/admin/sub_sub_categories', 'SubSubCategoriesController@destroy')->name('sub_sub_categories.destroy');
        Route::PUT('/admin/sub_sub_categories/{sub_category}/active', 'SubSubCategoriesController@active')->name('sub_sub_categories.active');
        Route::PUT('/admin/sub_sub_categories/{sub_category}/visibility', 'SubSubCategoriesController@visibility')->name('sub_sub_categories.visibility');
        /*********************************************** sub_sub_categories CRUD routes *******************************************/
        
        /*********************************************** brands CRUD routes *******************************************/
        Route::resource('/admin/brands', 'BrandsController');
        Route::delete('/admin/brands', 'BrandsController@destroy')->name('brands.destroy');
        Route::PUT('/admin/brands/{brand}/active', 'BrandsController@active')->name('brands.active');
        Route::PUT('/admin/brands/{brand}/visibility', 'BrandsController@visibility')->name('brands.visibility');
        /*********************************************** brands CRUD routes *******************************************/
        
        /*********************************************** warehouses CRUD routes *******************************************/
        Route::resource('/admin/warehouses', 'WarehousesController');
        Route::delete('/admin/warehouses', 'WarehousesController@destroy')->name('warehouses.destroy');
        /*********************************************** warehouses CRUD routes *******************************************/
        
        /*********************************************** Admin profile pages *******************************************/
        Route::get('/admin/profile', 'ProfileController@index')->name('admin.profile');
        Route::get('/admin/profile/edit', 'ProfileController@edit')->name('admin.profile.edit');
        Route::put('/admin/profile/edit', 'ProfileController@update')->name('admin.profile.edit');
        Route::get('/admin/profile/edit/password', 'ProfileController@editPassword')->name('admin.profile.edit.password');
        Route::PUT('/admin/profile/edit/password', 'ProfileController@updatePassword')->name('admin.profile.edit.password');
        Route::PUT('/admin/profile/edit/image', 'ProfileController@updateImage')->name('admin.profile.edit.image');
        Route::get('/admin/profile/settings', 'ProfileController@showSettings')->name('admin.profile.settings');
        Route::PUT('/admin/profile/edit/language', 'ProfileController@updateLanguage')->name('admin.profile.edit.language');
        /*********************************************** Admin profile pages *******************************************/

        /*********************************************** Users CRUD routes *******************************************/
        Route::resource('/admin/users', 'UsersController');
        Route::delete('/admin/users', 'UsersController@destroy')->name('users.destroy');
        Route::get('/admin/users/{user}/edit/password', 'UsersController@editPassword')->name('users.edit.password');
        Route::PUT('/admin/users/{user}/edit/password', 'UsersController@updatePassword')->name('users.edit.password');
        Route::PUT('/admin/users/{user}/active', 'UsersController@active')->name('users.active');
        /*********************************************** Users CRUD routes *******************************************/

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