<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\EmailVerificationResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class EmailVerificationResponse implements Responsable
{
    public function toResponse($request): RedirectResponse
    {
        // Logout user setelah verifikasi email
        Auth::guard(Filament::getAuthGuard())->logout();

        // Redirect ke halaman login
        return redirect()->to(Filament::getLoginUrl());
    }
}
