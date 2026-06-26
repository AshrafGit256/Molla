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
                    $mailHost = $mailsetting->mail_host;
                    $mailUsername = $mailsetting->mail_username;
                    $usesDemoSettings = in_array($mailHost, ['smtp.example.com', 'example.com'], true)
                        || in_array($mailUsername, ['demo@example.com', 'noreply@example.com'], true);

                    \Illuminate\Support\Facades\Config::set('mail.default', $mailsetting->mail_mailer ?: env('MAIL_MAILER', 'smtp'));
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp', [
                        'transport' => 'smtp',
                        'host' => $usesDemoSettings ? env('MAIL_HOST', 'smtp.gmail.com') : ($mailsetting->mail_host ?: env('MAIL_HOST', 'smtp.gmail.com')),
                        'port' => $usesDemoSettings ? env('MAIL_PORT', 587) : ($mailsetting->mail_port ?: env('MAIL_PORT', 587)),
                        'encryption' => $usesDemoSettings ? env('MAIL_ENCRYPTION', 'tls') : ($mailsetting->mail_encryption ?: env('MAIL_ENCRYPTION', 'tls')),
                        'username' => $usesDemoSettings ? env('MAIL_USERNAME') : ($mailsetting->mail_username ?: env('MAIL_USERNAME')),
                        'password' => $usesDemoSettings ? env('MAIL_PASSWORD') : ($mailsetting->mail_password ?: env('MAIL_PASSWORD')),
                        'timeout' => null,
                        'local_domain' => parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST),
                    ]);
                    \Illuminate\Support\Facades\Config::set('mail.from', [
                        'address' => $usesDemoSettings ? env('MAIL_FROM_ADDRESS', 'utraxagency1@gmail.com') : ($mailsetting->mail_from_address ?: env('MAIL_FROM_ADDRESS', 'utraxagency1@gmail.com')),
                        'name' => $mailsetting->name ?: env('MAIL_FROM_NAME', 'HenzNoval')
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // ignore during setup
        }
    }
}
