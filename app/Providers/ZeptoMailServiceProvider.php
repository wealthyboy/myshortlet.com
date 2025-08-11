<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\Transports\ZeptoMailTransport;
use Illuminate\Mail\MailManager;

class ZeptoMailServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->make(MailManager::class)->extend('zeptomail', function ($config) {
            return new ZeptoMailTransport(
                $config['token']
            );
        });
    }
}
