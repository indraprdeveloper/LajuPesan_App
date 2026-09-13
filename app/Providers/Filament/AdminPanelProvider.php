<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\StoreQrCodeWidget;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Auth\EmailVerificationPrompt;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->loginRouteSlug('masuk')
            ->registrationRouteSlug('daftar')
            ->emailVerificationRoutePrefix('verifikasi-email')
            ->emailVerificationPromptRouteSlug('/')
            ->favicon(asset('assets/images/logolajupesan.png'))
            ->brandName(fn () => \Illuminate\Support\Facades\Auth::user()?->name ?? 'LajuPesan')
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->registration(Register::class)
            ->emailVerification(EmailVerificationPrompt::class)
            ->passwordReset(\App\Filament\Pages\Auth\CustomPasswordReset::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->maxContentWidth(\Filament\Support\Enums\MaxWidth::Full)
            ->renderHook(
                'panels::head.end',
                function () {
                    return view('filament.admin-head');
                }
            )
            ->renderHook(
                'panels::body.end',
                function () {
                    /** @var \Illuminate\Http\Request $request */
                    $request = request();
                    $user = \Illuminate\Support\Facades\Auth::user();
                    
                    return $request->routeIs('filament.admin.pages.beranda') && $user instanceof \App\Models\User && $user->role === 'store'
                        ? \Illuminate\Support\Facades\Blade::render('<x-whatsapp-button />') 
                        : '';
                }
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                DashboardOverview::class,
                StoreQrCodeWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
