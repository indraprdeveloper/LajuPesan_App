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
            ->renderHook(
                'panels::head.end',
                fn () => \Illuminate\Support\Facades\Blade::render("
                    @vite('resources/js/app.js')
                    <style>
                        /* Sembunyikan hanya scrollbar vertikal */
                        ::-webkit-scrollbar:vertical {
                            display: none !important;
                        }
                        /* Sembunyikan ikon PC (System) dari theme switcher */
                        .fi-theme-switcher .fi-theme-switcher-btn:last-child {
                            display: none !important;
                        }
                        /* Perbaiki warna teks 'Jelajahi' pada upload file agar terlihat di light mode */
                        .filepond--label-action {
                            color: rgb(var(--primary-600)) !important;
                            text-decoration: underline;
                        }
                        .dark .filepond--label-action {
                            color: rgb(var(--primary-400)) !important;
                        }

                        /* Custom Cetak PDF Modal Styling for Mobile */
                        @media (max-width: 639px) {
                            .cetak-pdf-modal {
                                width: calc(100% - 1.5rem) !important;
                                max-width: none !important;
                                margin-left: 0.75rem !important;
                                margin-right: 0.75rem !important;
                            }
                            .cetak-pdf-modal label span,
                            .cetak-pdf-modal label {
                                font-size: 0.8rem !important;
                                white-space: nowrap !important;
                            }
                            .cetak-pdf-modal input {
                                font-size: 0.8rem !important;
                                padding-left: 0.5rem !important;
                                padding-right: 1.75rem !important;
                            }
                            .cetak-pdf-modal .fi-modal-footer {
                                display: block !important;
                                width: 100% !important;
                            }
                            .cetak-pdf-modal .fi-modal-footer-actions {
                                display: flex !important;
                                flex-direction: column !important;
                                width: 100% !important;
                                gap: 0.75rem !important;
                            }
                            .cetak-pdf-modal .fi-modal-footer-actions > button,
                            .cetak-pdf-modal .fi-modal-footer-actions > a,
                            .cetak-pdf-modal .fi-modal-footer-actions > div {
                                width: 100% !important;
                                display: flex !important;
                                justify-content: center !important;
                                margin: 0 !important;
                            }
                        }

                        /* Perbaikan Sidebar Mobile */
                        @media (max-width: 1023px) {
                            /* Lebar maksimal sidebar mobile agar menyisakan ruang tutup */
                            .fi-sidebar {
                                max-width: 75vw !important;
                            }
                            
                            /* Efek premium backdrop blur pada overlay mobile */
                            .fi-sidebar-close-overlay {
                                backdrop-filter: blur(4px) !important;
                                -webkit-backdrop-filter: blur(4px) !important;
                                background-color: rgba(15, 23, 42, 0.4) !important; /* Premium slate color */
                            }
                            
                            /* Penyelarasan header sidebar saat mobile */
                            .fi-sidebar-header {
                                display: flex !important;
                                justify-content: space-between !important;
                                align-items: center !important;
                            }

                            /* Agar label menu tidak terpotong (wrap) di mobile */
                            .fi-sidebar-item-label {
                                white-space: normal !important;
                                overflow: visible !important;
                                text-overflow: clip !important;
                                word-break: break-word !important;
                            }
                        }


                        /* Custom Store QR Code Widget styling */
                        .qr-code-widget-wrapper {
                            display: flex !important;
                            flex-direction: row !important;
                            align-items: center !important;
                            gap: 2rem !important;
                            width: 100% !important;
                        }
                        .qr-code-panel {
                            flex-shrink: 0 !important;
                            display: flex !important;
                            flex-direction: column !important;
                            align-items: center !important;
                            gap: 0.75rem !important;
                        }
                        .qr-code-details {
                            flex: 1 1 0% !important;
                            text-align: left !important;
                        }
                        .qr-code-details h2 {
                            text-align: left !important;
                        }
                        .qr-code-details p {
                            text-align: left !important;
                            margin-left: 0 !important;
                            margin-right: auto !important;
                        }
                        .qr-code-buttons {
                            display: flex !important;
                            flex-direction: row !important;
                            flex-wrap: wrap !important;
                            align-items: center !important;
                            justify-content: flex-start !important;
                            gap: 0.75rem !important;
                            width: 100% !important;
                        }
                        .qr-code-btn {
                            display: inline-flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            width: auto !important;
                            white-space: nowrap !important;
                            flex-shrink: 0 !important;
                        }

                        @media (max-width: 639px) {
                            .qr-code-widget-wrapper {
                                flex-direction: column !important;
                                gap: 1.5rem !important;
                            }
                            .qr-code-panel {
                                width: 100% !important;
                            }
                            .qr-code-details {
                                text-align: center !important;
                                width: 100% !important;
                            }
                            .qr-code-details h2 {
                                text-align: center !important;
                            }
                            .qr-code-details p {
                                text-align: center !important;
                                margin-left: auto !important;
                                margin-right: auto !important;
                            }
                            .qr-code-buttons {
                                flex-direction: column !important;
                                align-items: stretch !important;
                                width: 100% !important;
                            }
                            .qr-code-btn {
                                width: 100% !important;
                                justify-content: center !important;
                            }
                        }
                    </style>

                    <script>
                        (function() {
                            function applyMobileNavigationImprovements() {
                                injectMobileCloseButton();
                                initSwipeToClose();
                            }

                            function injectMobileCloseButton() {
                                const sidebarHeader = document.querySelector('.fi-sidebar-header');
                                if (!sidebarHeader) return;

                                // Check if the mobile close button already exists
                                if (sidebarHeader.querySelector('.fi-sidebar-mobile-close-btn')) return;

                                // Create the button
                                const closeBtn = document.createElement('button');
                                closeBtn.className = 'fi-sidebar-mobile-close-btn lg:hidden ms-auto flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none';
                                closeBtn.setAttribute('aria-label', 'Close sidebar');
                                closeBtn.style.marginLeft = 'auto'; // push it to the far right
                                
                                // Set SVG icon (Heroicon X)
                                closeBtn.innerHTML = '<svg class=\"w-6 h-6\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" style=\"width: 24px; height: 24px;\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18 18 6M6 6l12 12\" /></svg>';

                                // Click handler to close sidebar
                                closeBtn.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    try {
                                        if (window.Alpine && window.Alpine.store('sidebar')) {
                                            window.Alpine.store('sidebar').close();
                                            return;
                                        }
                                    } catch(err) {}
                                    
                                    // Fallback: Click the overlay
                                    const overlay = document.querySelector('.fi-sidebar-close-overlay');
                                    if (overlay) overlay.click();
                                });

                                // Append to sidebar header
                                sidebarHeader.appendChild(closeBtn);
                            }

                            function initSwipeToClose() {
                                const sidebar = document.querySelector('.fi-sidebar');
                                if (!sidebar) return;

                                // Prevent duplicate listeners
                                if (sidebar.dataset.swipeInitialized) return;
                                sidebar.dataset.swipeInitialized = 'true';

                                let touchStartX = 0;
                                let touchStartY = 0;
                                let touchEndX = 0;
                                let touchEndY = 0;

                                sidebar.addEventListener('touchstart', (e) => {
                                    touchStartX = e.changedTouches[0].screenX;
                                    touchStartY = e.changedTouches[0].screenY;
                                }, { passive: true });

                                sidebar.addEventListener('touchend', (e) => {
                                    touchEndX = e.changedTouches[0].screenX;
                                    touchEndY = e.changedTouches[0].screenY;
                                    handleSwipe();
                                }, { passive: true });

                                function handleSwipe() {
                                    const diffX = touchEndX - touchStartX;
                                    const diffY = touchEndY - touchStartY;

                                    // We want a swipe to the left (negative diffX)
                                    // Ensure vertical movement is minimal (to not trigger when scrolling down/up)
                                    const thresholdX = -60; // Swiped at least 60px to the left
                                    const thresholdY = 40;  // Vertical limit

                                    if (diffX < thresholdX && Math.abs(diffY) < thresholdY) {
                                        try {
                                            if (window.Alpine && window.Alpine.store('sidebar')) {
                                                window.Alpine.store('sidebar').close();
                                                return;
                                            }
                                        } catch(err) {}
                                        
                                        const overlay = document.querySelector('.fi-sidebar-close-overlay');
                                        if (overlay) overlay.click();
                                    }
                                }
                            }

                            // Run immediately and on relevant events
                            if (document.readyState === 'loading') {
                                document.addEventListener('DOMContentLoaded', applyMobileNavigationImprovements);
                            } else {
                                applyMobileNavigationImprovements();
                            }

                            document.addEventListener('livewire:navigated', applyMobileNavigationImprovements);
                            document.addEventListener('livewire:load', applyMobileNavigationImprovements);

                            // Use MutationObserver to handle dynamic DOM replacement/hydration by Livewire
                            const observer = new MutationObserver((mutations) => {
                                const sidebarHeader = document.querySelector('.fi-sidebar-header');
                                if (sidebarHeader && !sidebarHeader.querySelector('.fi-sidebar-mobile-close-btn')) {
                                    applyMobileNavigationImprovements();
                                }
                            });

                            observer.observe(document.body, {
                                childList: true,
                                subtree: true
                            });
                        })();
                    </script>
                ")
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
