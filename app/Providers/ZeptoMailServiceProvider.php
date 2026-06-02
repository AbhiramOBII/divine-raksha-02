<?php

namespace App\Providers;

use App\Mail\Transport\ZeptoMailTransport;
use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;

class ZeptoMailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->afterResolving(MailManager::class, function (MailManager $manager) {
            $manager->extend('zeptomail', function () {
                return new ZeptoMailTransport(
                    config('services.zeptomail.token', env('ZEPTOMAIL_TOKEN', '')),
                    config('services.zeptomail.host', env('ZEPTOMAIL_HOST', 'api.zeptomail.in'))
                );
            });
        });
    }
}
