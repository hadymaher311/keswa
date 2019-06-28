<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SubSubCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if(config('app.env') === 'production') {
        //     \URL::forceScheme('https');
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Using Closure based composers...
        View::composer('user.*', function ($view) {
            $visible_categories = Category::where('navbar_visibility', '1')->active()->get();
            $all_categories = Category::active()->get();
            $all_sub_sub_categories = SubSubCategory::active()->get();
            $view->with([
                'visible_categories' => $visible_categories,
                'all_categories' => $all_categories,
                'all_sub_sub_categories' => $all_sub_sub_categories,
            ]);
        });

        Validator::extend('base64', function ($attribute, $value, $parameters, $validator) {
            if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $value)) {
                return true;
            } else {
                return false;
            }
        });
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'jpeg', 'svg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }
            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }
            return true;
        });

    }
}
