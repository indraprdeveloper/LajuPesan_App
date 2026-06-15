<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class StoreQrCodeController extends Controller
{
    public function download()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'store') {
            abort(403, 'Aksi tidak diizinkan.');
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

        // Generate QR Code with cleared center
        $qr = QrCode::size(500)->errorCorrection('H')->margin(2);
        if ($logoPath && file_exists($logoPath)) {
            $qr = $qr->merge($logoPath, 0.22, true);
        }
        $svg = (string) $qr->generate($storeUrl);

        // Inject the logo dynamically into the SVG XML for high-resolution output
        if ($logoPath && file_exists($logoPath)) {
            try {
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoMime = mime_content_type($logoPath);
                $logoDataUri = 'data:' . $logoMime . ';base64,' . $logoData;

                $logoSvg = '<circle cx="250" cy="250" r="60" fill="#ffffff" stroke="#e5e7eb" stroke-width="3" />';
                $logoSvg .= '<image href="' . $logoDataUri . '" x="200" y="200" width="100" height="100" clip-path="inset(0% round 50%)" />';
                $logoSvg .= '</svg>';

                $svg = str_replace('</svg>', $logoSvg, $svg);
            } catch (\Exception $e) {
                // Return standard SVG if error occurs
            }
        }

        $filename = 'qrcode-' . $user->username . '.svg';

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
