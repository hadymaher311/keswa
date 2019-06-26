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
        Route::get('/brand/products/{brand}', 'ProductsController@brand')->name('user.products.brand.show');
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
            
            // product reviews
            Route::post('/user/reviews/{product}', 'ProductsController@storeReview')->name('user.review.store');


            // profile and account routes
            Route::get('/user/profile', 'ProfileController@index')->name('user.profile');
            Route::PUT('/user/profile/edit/image', 'ProfileController@updateImage')->name('user.profile.edit.image');
            Route::get('/user/profile/edit/info', 'ProfileController@editInfo')->name('user.info.edit');
            Route::PUT('/user/profile/info/update', 'ProfileController@updateInfo')->name('user.info.update');
            Route::PUT('/user/profile/password/update', 'ProfileController@updatePassword')->name('user.password.update');
            Route::get('/user/profile/addresses', 'ProfileController@showAddress')->name('user.addresses');
            Route::POST('/user/profile/addresses/store', 'ProfileController@storeAddress')->name('user.addresses.store');
            Route::get('/user/profile/addresses/{address}/edit', 'ProfileController@editAddress')->name('user.addresses.edit');
            Route::PUT('/user/profile/addresses/{address}/update', 'ProfileController@updateAddress')->name('user.addresses.update');


            Route::get('/home', 'HomeController@welcome')->name('home');
        });
    });
});