<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\SimplePage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class CustomPasswordReset extends SimplePage
{
    protected static string $view = 'filament.pages.auth.custom-password-reset';

    public $email = '';
    public $otp = '';
    public $password = '';
    public $passwordConfirmation = '';

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Reset Password';
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function sendOtp()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar di sistem.',
        ]);

        // Generate 6 digit OTP
        $generatedOtp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Simpan OTP di cache selama 10 menit
        Cache::put('otp_reset_' . $this->email, $generatedOtp, now()->addMinutes(10));

        // Kirim OTP melalui Email
        $user = User::where('email', $this->email)->first();
        \Illuminate\Support\Facades\Mail::to($this->email)
            ->queue(new \App\Mail\PasswordResetOtpMail($user->name, $generatedOtp));
        
        Notification::make()
            ->title('OTP Terkirim')
            ->body('Kode OTP telah dikirim ke email Anda. Silakan cek inbox.')
            ->success()
            ->send();
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|min:8|same:passwordConfirmation',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.exists' => 'Email tidak terdaftar.',
            'otp.required' => 'Kode token wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $cachedOtp = Cache::get('otp_reset_' . $this->email);

        if (!$cachedOtp || $cachedOtp !== $this->otp) {
            Notification::make()
                ->title('Token Tidak Valid')
                ->body('Kode token salah atau sudah kedaluwarsa.')
                ->danger()
                ->send();
            return;
        }

        // Update password
        $user = User::where('email', $this->email)->first();
        $user->password = Hash::make($this->password);
        $user->save();

        // Hapus cache OTP
        Cache::forget('otp_reset_' . $this->email);

        Notification::make()
            ->title('Berhasil')
            ->body('Kata sandi berhasil diubah. Silakan login.')
            ->success()
            ->send();

        return redirect()->route('filament.admin.auth.login');
    }
}
