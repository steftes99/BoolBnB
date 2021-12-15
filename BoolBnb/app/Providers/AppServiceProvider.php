<?php

namespace App\Providers;

use Braintree\Gateway;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(Gateway::class, function($app){
            return new Gateway([
                'environment' => 'sandbox',
                'merchantId' => 'ptngw3wjz8jfcmh5',
                'publicKey' => 'bvw5wz4q7rk68j8y',
                'privateKey' => 'ed2160011f1f47fa68bd7cd005fe2331'
            ]);
        });
    }
}
