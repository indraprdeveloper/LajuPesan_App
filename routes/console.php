<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Hapus akun yang belum verifikasi email setelah 48 jam, setiap hari jam 00:00
Schedule::command('users:clean-unverified --hours=48')->daily();
