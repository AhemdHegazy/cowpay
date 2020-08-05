<?php

namespace Esameisa\Cowpay\Providers;

use Esameisa\Cowpay\Strategy\Cowpay;
use Esameisa\Cowpay\Strategy\CreditCard;
use Esameisa\Cowpay\Strategy\Fawry;
use Illuminate\Support\ServiceProvider;

class CowpayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->singleton(Cowpay::class, function () {

            $base_url = config('cowpay.api_base_url');
            $merchant_code = config('cowpay.merchant_code');
            $m_hash_key = config('cowpay.m_hash_key');
            $currency = config('cowpay.currency');

            return new Cowpay($base_url, $merchant_code, $m_hash_key, $currency);
        });


        // php artisan vendor:publish
        $this->publishes([
            dirname(dirname(__FILE__)) . '/config/cowpay.php' => config_path('cowpay.php'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // code
    }
}
