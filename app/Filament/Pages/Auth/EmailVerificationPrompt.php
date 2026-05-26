<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt as BasePrompt;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\RateLimiter;

class EmailVerificationPrompt extends BasePrompt
{
    protected static string $view = 'filament.pages.auth.email-verification-prompt';
    
    protected static ?string $title = 'Verifikasi Email';

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Verifikasi Email';
    }

    public string $otp = '';

    /**
     * Verify the OTP code submitted by the user.
     */
    public function verifyOtp(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Filament::auth()->user();

        if (!$user) {
            $this->redirect(Filament::getLoginUrl());
            return;
        }

        // Validate input
        if (strlen($this->otp) !== 6 || !ctype_digit($this->otp)) {
            $this->dispatch('otp-error');
            return;
        }

        // Rate limit: max 5 attempts per minute
        $rateLimitKey = 'otp-verify:' . $user->id;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $this->dispatch('otp-error');
            return;
        }

        RateLimiter::hit($rateLimitKey, 60);

        // Check if OTP has expired
        if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
            $this->dispatch('otp-error');
            $this->otp = '';
            return;
        }

        // Verify OTP
        if (!$user->verifyOtp($this->otp)) {
            $this->dispatch('otp-error');
            $this->otp = '';
            return;
        }

        // OTP is valid — mark email as verified
        $user->markEmailAsVerified();
        $user->clearOtp();

        // Clear rate limiter
        RateLimiter::clear($rateLimitKey);

        Notification::make()
            ->title('Email berhasil diverifikasi! 🎉')
            ->body('Selamat datang di LajuPesan.')
            ->success()
            ->send();

        // Stay authenticated, redirect to dashboard
        $this->redirect(Filament::getUrl());
    }

    /**
     * Resend the OTP code with rate limiting.
     */
    public function resendOtp(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Filament::auth()->user();

        if (!$user) {
            $this->redirect(Filament::getLoginUrl());
            return;
        }

        // Rate limit: max 1 resend per 60 seconds
        $rateLimitKey = 'otp-resend:' . $user->id;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            Notification::make()
                ->title("Harap tunggu {$seconds} detik sebelum mengirim ulang kode.")
                ->warning()
                ->send();
            return;
        }

        RateLimiter::hit($rateLimitKey, 60);

        // Generate new OTP and send email
        $user->sendEmailVerificationNotification();

        Notification::make()
            ->title('Kode OTP baru telah dikirim!')
            ->body('Periksa inbox email Anda.')
            ->success()
            ->send();

        $this->otp = '';
    }
}
