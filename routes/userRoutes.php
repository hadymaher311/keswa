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
            
            Route::get('/user/profile/edit/info', 'ProfileController@editInfo')->name('user.info.edit');
            Route::PUT('/user/profile/info/update', 'ProfileController@updateInfo')->name('user.info.update');
            Route::PUT('/user/profile/password/update', 'ProfileController@updatePassword')->name('user.password.update');
            Route::POST('/user/photo/edit', 'ProfileController@editImage')->name('user.profile.image.edit');
            
            Route::get('/user/profile/addresses', 'ProfileController@showAddress')->name('user.addresses');
            Route::POST('/user/profile/addresses/store', 'ProfileController@storeAddress')->name('user.addresses.store');
            Route::get('/user/profile/addresses/{address}/edit', 'ProfileController@editAddress')->name('user.addresses.edit');
            Route::get('/user/profile/addresses/{address}/main_location', 'ProfileController@main_location')->name('user.addresses.main_location');
            Route::PUT('/user/profile/addresses/{address}/update', 'ProfileController@updateAddress')->name('user.addresses.update');
            Route::DELETE('/user/profile/addresses/{address}/delete', 'ProfileController@destroyAddress')->name('user.addresses.delete');

            Route::get('/user/profile/reviews', 'ProfileController@showReviews')->name('user.reviews');
            Route::get('/user/profile/reviews/{review}/edit', 'ProfileController@editReviews')->name('user.reviews.edit');
            Route::PUT('/user/profile/reviews/{review}/update', 'ProfileController@updateReviews')->name('user.reviews.update');
            Route::DELETE('/user/profile/reviews/{review}/destroy', 'ProfileController@destroyReviews')->name('user.reviews.destroy');
            

            /*********************************************** Orders routes *******************************************/
            Route::get('/user/orders', 'OrdersController@index')->name('user.orders');
            Route::get('/user/orders/checkout', 'OrdersController@checkout')->name('user.orders.checkout');
            Route::post('/user/orders/confirm', 'OrdersController@confirm')->name('user.orders.confirm');
            Route::get('/user/orders/details/{order}', 'OrdersController@details')->name('user.orders.details');
            Route::post('/user/orders/{order}/cancel', 'OrdersController@cancel')->name('user.orders.cancel');
            Route::get('/user/orders/review/{order}', 'OrdersController@review')->name('user.orders.review');
            /*********************************************** Orders routes *******************************************/
            
            /*********************************************** Returns routes *******************************************/
            Route::get('/user/returns', 'ReturnsController@index')->name('user.returns');
            Route::post('/user/returns/{order}/confirm/{product}', 'ReturnsController@confirm')->name('user.returns.confirm');
            Route::get('/user/returns/details/{return}', 'ReturnsController@details')->name('user.returns.details');
            Route::post('/user/returns/{return}/cancel', 'ReturnsController@cancel')->name('user.returns.cancel');
            /*********************************************** Returns routes *******************************************/
            Route::get('/home', 'HomeController@welcome')->name('home');
        });
    });
});