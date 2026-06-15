<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class StoreQrCodeWidget extends Widget
{
    protected static string $view = 'filament.widgets.store-qr-code-widget';

    protected int | string | array $columnSpan = 'full';

    // Sort this widget to display right below DashboardOverview (stats)
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === 'store';
    }

    public function getQrCode(): string
    {
        $user = Auth::user();
        if (!$user) {
            return '';
        }

        $storeUrl = route('index', ['username' => $user->username]);

        $logoPath = null;
        if ($user->logo) {
            if (str_starts_with($user->logo, 'assets/')) {
                $logoPath = public_path($user->logo);
            } else {
                $logoPath = storage_path('app/public/' . $user->logo);
            }
        }

        // Fallback to default LajuPesan logo if store has no logo or logo file is missing
        if (!$logoPath || !file_exists($logoPath)) {
            $defaultLogo = public_path('assets/images/logolajupesan.png');
            if (file_exists($defaultLogo)) {
                $logoPath = $defaultLogo;
            } else {
                $logoPath = null;
            }
        }

        // Generate QR code with a cleared center area
        $qr = QrCode::size(160)->errorCorrection('H')->margin(1);
        if ($logoPath && file_exists($logoPath)) {
            $qr = $qr->merge($logoPath, 0.22, true);
        }
        $svg = (string) $qr->generate($storeUrl);

        // Inject the logo image dynamically into the SVG XML using native tags
        if ($logoPath && file_exists($logoPath)) {
            try {
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoMime = mime_content_type($logoPath);
                $logoDataUri = 'data:' . $logoMime . ';base64,' . $logoData;

                $logoSvg = '<circle cx="80" cy="80" r="19" fill="#ffffff" stroke="#e5e7eb" stroke-width="1" />';
                $logoSvg .= '<image href="' . $logoDataUri . '" x="64" y="64" width="32" height="32" clip-path="inset(0% round 50%)" />';
                $logoSvg .= '</svg>';

                $svg = str_replace('</svg>', $logoSvg, $svg);
            } catch (\Exception $e) {
                // Return standard SVG if any error occurs
            }
        }

        return $svg;
    }

    public function getStoreUrl(): string
    {
        $user = Auth::user();
        return $user ? route('index', ['username' => $user->username]) : url('/');
    }
}
