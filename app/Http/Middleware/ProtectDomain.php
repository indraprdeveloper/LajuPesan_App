<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedDomains = [
            'lajupesan.com',
            'www.lajupesan.com',
            'localhost',
            '127.0.0.1',
        ];

        $host = $request->getHost();

        // Jika host tidak ada di daftar yang diizinkan dan tidak berakhiran .test (untuk Laragon lokal)
        if (!in_array($host, $allowedDomains) && !str_ends_with($host, '.test')) {
            abort(403, 'Unauthorized Domain Access');
        }

        return $next($request);
    }
}
