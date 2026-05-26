<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Events\TransactionStatusUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoFailCashTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $transactionId
    ) {}

    public function handle(): void
    {
        $transaction = Transaction::find($this->transactionId);

        // Jika transaksi tidak ditemukan atau statusnya sudah bukan pending, abaikan
        if (!$transaction || $transaction->status !== 'pending') {
            return;
        }

        // Ubah status menjadi gagal
        $transaction->update(['status' => 'failed']);

        // Kirim notifikasi real-time ke dashboard admin
        TransactionStatusUpdated::dispatch($transaction);
    }
}
