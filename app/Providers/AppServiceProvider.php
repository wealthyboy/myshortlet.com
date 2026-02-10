<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Swift_Mailer;

use Illuminate\Support\Facades\Storage;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use League\Flysystem\Filesystem as Flysystem;
use Google\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Storage::extend('google', function ($app, $config) {
            $client = new Client();
            $client->setAuthConfig($config['service_account_credentials_json']);
            $client->addScope(\Google_Service_Drive::DRIVE);

            $service = new \Google_Service_Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folder_id']);

            return new Flysystem($adapter);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {}
}
