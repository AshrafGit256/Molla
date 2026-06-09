<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\SMTPModel;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('smtp')) {

                $mailsetting = \App\Models\SMTPModel::getSingle();

                if ($mailsetting) {
                    \Illuminate\Support\Facades\Config::set('mail', [
                        'driver' => $mailsetting->mail_mailer,
                        'host' => $mailsetting->mail_host,
                        'port' => $mailsetting->mail_port,
                        'encryption' => $mailsetting->mail_encryption,
                        'username' => $mailsetting->mail_username,
                        'password' => $mailsetting->mail_password,
                        'from' => [
                            'address' => $mailsetting->mail_from_address,
                            'name' => $mailsetting->name
                        ]
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // ignore during setup
        }
    }
}
