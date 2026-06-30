<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class Register extends BaseRegister
{
    protected static string $view = 'filament.pages.auth.register';

    public function register(): ?RegistrationResponse
    {
        $this->callHook('beforeValidate');
        $data = $this->form->getState();
        $this->callHook('afterValidate');

        $this->callHook('beforeRegister');
        /** @var \App\Models\User $user */
        $user = $this->handleRegistration($data);
        $this->callHook('afterRegister');

        // Login user agar bisa akses halaman verifikasi
        Auth::guard(Filament::getAuthGuard())->login($user);

        // Kirim email verifikasi otomatis
        $user->sendEmailVerificationNotification();

        return app(RegistrationResponse::class);
    }
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                ->schema([
                  $this->getLogoFormComponent(),
                  $this->getNameFormComponent(),
                  $this->getUsernameFormComponent(),
                  $this->getEmailFormComponent(),
                  $this->getPasswordFormComponent(),
                  $this->getPasswordConfirmationFormComponent(),
                ])
                ->statePath('data'),
                ),
            ];
    }

    public function getRegisterFormAction(): \Filament\Actions\Action
    {
        return parent::getRegisterFormAction()
            ->label('Daftar Sekarang');
    }

    protected function getLogoFormComponent(): Component
    {
        return FileUpload::make('logo')
        ->label('Logo Toko')
        ->validationAttribute('logo toko')
        ->image()
        ->required();
    }

    protected function getNameFormComponent(): Component
    {
        return parent::getNameFormComponent()
            ->label('Nama Toko')
            ->validationAttribute('nama toko')
            ->placeholder('Masukkan nama toko Anda')
            ->prefixIcon('heroicon-o-building-storefront');
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
        ->label('Username')
        ->placeholder('pilih_username_unik')
        ->prefixIcon('heroicon-o-at-symbol')
        ->hint('Minimal 5 karakter, tidak boleh ada spasi.')
        ->required()
        ->rules(['min:5'])
        ->unique($this->getUserModel());
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()
            ->label('Alamat Email')
            ->validationAttribute('alamat email')
            ->placeholder('email@bisnisanda.com')
            ->prefixIcon('heroicon-o-envelope');
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label('Kata Sandi')
            ->validationAttribute('kata sandi')
            ->placeholder('Min. 8 karakter')
            ->prefixIcon('heroicon-o-lock-closed');
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return parent::getPasswordConfirmationFormComponent()
            ->label('Konfirmasi Kata Sandi')
            ->validationAttribute('konfirmasi kata sandi')
            ->placeholder('Ulangi kata sandi')
            ->prefixIcon('heroicon-o-lock-closed');
    }
}
