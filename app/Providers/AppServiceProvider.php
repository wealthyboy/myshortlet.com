<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use App\Mail\Transport\ZeptoMailTransport;
use Swift_Mailer;

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
         Mail::extend('zeptomail', function () {
            return new Swift_Mailer(
                new ZeptoMailTransport(
                   config('mail.mailers.zeptomail.token') 
                )
            );
        });
    }
}
