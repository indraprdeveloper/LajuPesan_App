<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi — LajuPesan</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7f9fb; font-family: 'Segoe UI', 'Inter', Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f9fb; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="460" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    
                    {{-- Header with amber accent --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 32px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: -0.02em;">
                                LajuPesan
                            </h1>
                            <p style="margin: 8px 0 0; color: rgba(255,255,255,0.85); font-size: 13px; font-weight: 400;">
                                Verifikasi Alamat Email Anda
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 36px 40px;">
                            <p style="margin: 0 0 8px; color: #191c1e; font-size: 16px; font-weight: 600;">
                                Halo, {{ $userName }}
                            </p>
                            <p style="margin: 0 0 28px; color: #534434; font-size: 14px; line-height: 22px;">
                                Terima kasih telah mendaftar di LajuPesan. Masukkan kode verifikasi berikut untuk mengaktifkan akun Anda:
                            </p>

                            {{-- OTP Code Box --}}
                            <div style="text-align: center; margin: 0 0 28px;">
                                <div style="display: inline-block; background-color: #fffbeb; border: 2px dashed #f59e0b; border-radius: 12px; padding: 20px 40px;">
                                    <span style="font-size: 36px; font-weight: 700; letter-spacing: 10px; color: #855300; font-family: 'Courier New', monospace;">
                                        {{ $otpCode }}
                                    </span>
                                </div>
                            </div>

                            <p style="margin: 0 0 6px; color: #534434; font-size: 13px; line-height: 20px; text-align: center;">
                                Kode ini berlaku selama <strong>10 menit</strong>.
                            </p>
                            <p style="margin: 0 0 28px; color: #867461; font-size: 12px; line-height: 18px; text-align: center;">
                                Jika Anda tidak merasa mendaftar, abaikan email ini.
                            </p>

                            {{-- Security Warning --}}
                            <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 8px; padding: 14px 16px;">
                                <p style="margin: 0; color: #991b1b; font-size: 12px; font-weight: 600;">
                                    Keamanan
                                </p>
                                <p style="margin: 4px 0 0; color: #7f1d1d; font-size: 12px; line-height: 18px;">
                                    Jangan pernah membagikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari LajuPesan.
                                </p>
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 20px 40px; border-top: 1px solid #e0e3e5; text-align: center;">
                            <p style="margin: 0; color: #867461; font-size: 11px;">
                                © {{ date('Y') }} LajuPesan
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
