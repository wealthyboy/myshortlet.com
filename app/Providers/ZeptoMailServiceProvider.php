<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use App\Mail\ZeptoMailTransport; // your custom transport class
use Illuminate\Support\Arr;


class ZeptoMailServiceProvider extends ServiceProvider
{


    public function boot()
    {
        $this->app->make(MailManager::class)->extend('zeptomail', function (array $config) {
            // fallback to global mail config if needed
            $config = array_merge([
                'api_key' => config('mail.mailers.zeptomail.key'),
                'host' => config('mail.mailers.zeptomail.host'),
            ], $config);


            return new ZeptoMailTransport(
                Arr::get($config, 'api_key'),
                Arr::get($config, 'host')
            );
        });
    }


    public function register()
    {
        //$this->mergeConfigFrom(__DIR__.'/../config/zeptomaildriver.php', 'zeptomaildriver');
    }
}
