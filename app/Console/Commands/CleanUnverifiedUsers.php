<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CleanUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:clean-unverified {--hours=48 : Hapus user yang belum verifikasi setelah jam tertentu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus akun user yang belum memverifikasi email setelah batas waktu tertentu';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');

        $users = User::whereNull('email_verified_at')
            ->where('created_at', '<', now()->subHours($hours))
            ->where('role', 'store') // Hanya hapus akun store, bukan admin
            ->get();

        if ($users->isEmpty()) {
            $this->info('Tidak ada akun yang perlu dihapus.');
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($users as $user) {
            // Hapus logo user jika ada
            if ($user->logo && Storage::disk('public')->exists($user->logo)) {
                Storage::disk('public')->delete($user->logo);
            }

            // Hapus user (soft delete karena model pakai SoftDeletes)
            $user->forceDelete();
            $count++;
        }

        $this->info("Berhasil menghapus {$count} akun yang belum diverifikasi (lebih dari {$hours} jam).");
        Log::info("CleanUnverifiedUsers: Menghapus {$count} akun yang belum diverifikasi.");

        return Command::SUCCESS;
    }
}
