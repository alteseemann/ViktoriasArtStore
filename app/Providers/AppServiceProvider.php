<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\type;
use Illuminate\Support\Facades\View;

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
        View::share('types',type::where('is_active',1)->get());
    }
}
