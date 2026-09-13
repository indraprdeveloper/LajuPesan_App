<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Filament\Http\Responses\Auth\Contracts\EmailVerificationResponse as EmailVerificationResponseContract;
use App\Http\Responses\EmailVerificationResponse;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse as RegistrationResponseContract;
use App\Http\Responses\RegistrationResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override response setelah verifikasi email → logout + redirect ke login
        $this->app->bind(EmailVerificationResponseContract::class, EmailVerificationResponse::class);

        // Override response setelah registrasi → langsung redirect ke verifikasi email
        $this->app->bind(RegistrationResponseContract::class, RegistrationResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
