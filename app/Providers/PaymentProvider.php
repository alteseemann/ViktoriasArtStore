<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\SberPayment;
use App\Helpers\PayPalPayment;


class PaymentProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\Contracts\Payable', function(){
            return new PayPalPayment();
            //return new saveImageDisk();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
