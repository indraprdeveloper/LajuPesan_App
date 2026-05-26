<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Filament\Http\Responses\Auth\Contracts\EmailVerificationResponse as EmailVerificationResponseContract;
use App\Http\Responses\EmailVerificationResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override response setelah verifikasi email → logout + redirect ke login
        $this->app->bind(EmailVerificationResponseContract::class, EmailVerificationResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_contains(request()->url(), 'ngrok')) {
            URL::forceScheme('https');
        }

        // Override URL verifikasi email agar menggunakan route Filament
        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                'filament.admin.auth.email-verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });
    }
}
