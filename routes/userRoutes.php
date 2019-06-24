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
        Route::get('/', 'HomeController@welcome')->name('welcome');
        Route::get('/products/{product}/{slug}', 'ProductsController@show')->name('user.products.show');
        Route::get('/category/products/{category}', 'ProductsController@category')->name('user.products.category.show');
        Route::get('/products/search', 'ProductsController@search')->name('user.products.search');

        // blocked user routes for auth only
        Route::group(['middleware' => ['auth', 'verified'],], function() {
            // cart routes
            Route::get('/user/cart', 'CartController@show')->name('user.cart');
            Route::post('/user/cart/{product}', 'CartController@store')->name('user.cart.store');
            Route::PUT('/user/cart/{product}/update', 'CartController@update')->name('user.cart.update');
            Route::DELETE('/user/cart/{product}/destroy', 'CartController@destroy')->name('user.cart.remove');
            
            // WishList routes
            Route::get('/user/wishlist', 'WishListController@show')->name('user.wishlist');
            Route::post('/user/wishlist/{product}', 'WishListController@store')->name('user.wishlist.store');
            Route::DELETE('/user/wishlist/{product}/destroy', 'WishListController@destroy')->name('user.wishlist.remove');


            // profile and account routes
            Route::get('/home', 'HomeController@index')->name('home');
        });
    });
});