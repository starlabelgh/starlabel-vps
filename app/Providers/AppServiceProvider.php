<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if(file_exists(storage_path('installed'))){
            if(setting('locale')){
                App::setLocale(setting('locale'));
            }
            View::composer('admin.layouts.components.sidebar', 'App\Http\Composers\BackendMenuComposer');
            View::composer('partials._footer', 'App\Http\Composers\FrontendFooterComposer');
        }
  
    }
}
