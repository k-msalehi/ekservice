<?php

namespace App\Providers;

use App\Services\Sms\Kavenegar;
use App\Services\Sms\LogSms;
use App\Services\Sms\Sms;
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
        $this->app->singleton('res', function () {
            return new \App\Services\Http\Response;
        });

        $this->app->bind(Sms::class, function () {
            return new LogSms();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
