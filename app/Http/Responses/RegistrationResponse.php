<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse as Responsable;

class RegistrationResponse implements Responsable
{
    public function toResponse($request)
    {
        // Langsung redirect ke halaman verifikasi email, tanpa melewati dashboard
        return redirect()->to(route('filament.admin.auth.email-verification.prompt'));
    }
}
