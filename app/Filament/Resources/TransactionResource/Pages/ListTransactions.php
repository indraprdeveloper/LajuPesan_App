<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Transaksi'),
        ];
    }

    protected function getListeners(): array
    {
        $storeId = Auth::id();

        return [
            "echo:store.{$storeId},TransactionStatusUpdated" => 'onTransactionUpdated',
        ];
    }

    public function onTransactionUpdated($data): void
    {
        $code = $data['code'] ?? '';
        $status = $data['status'] ?? '';
        $paymentMethod = $data['payment_method'] ?? '';
        $name = $data['name'] ?? '';

        // Auto-refresh tabel agar data terbaru langsung muncul
        $this->resetTable();

        if ($status === 'pending') {
            if ($paymentMethod === 'cash') {
                // 🔊 Putar suara notifikasi transaksi tunai masuk
                $this->dispatch('play-transaction-sound', type: 'cash-pending');

                Notification::make()
                    ->title('💵 Pesanan (TUNAI)')
                    ->body("Nama: {$name}\nKode Transaksi: {$code}")
                    ->warning()
                    ->duration(10000)
                    ->send();
            } else {
                Notification::make()
                    ->title('💳 Pesanan (NON-TUNAI)')
                    ->body("Nama: {$name}\nKode Transaksi: {$code}")
                    ->info()
                    ->duration(10000)
                    ->send();
            }
        } elseif ($status === 'success') {
            if ($paymentMethod === 'cash') {
                Notification::make()
                    ->title('✅ Pembayaran Selesai')
                    ->body("Nama: {$name}\nKode Transaksi: {$code}")
                    ->success()
                    ->duration(10000)
                    ->send();
            } else {
                // 🔊 Putar suara notifikasi pembayaran non-tunai berhasil
                $this->dispatch('play-transaction-sound', type: 'non-cash-success');

                Notification::make()
                    ->title('🎉 Pembayaran Non-Tunai SUKSES!')
                    ->body("Nama: {$name}\nKode Transaksi: {$code}")
                    ->success()
                    ->duration(10000)
                    ->send();
            }
        } elseif ($status === 'failed') {
            if ($paymentMethod === 'cash') {
                Notification::make()
                    ->title('❌ Pembayaran Tunai Gagal')
                    ->body("Nama: {$name}\nKode Transaksi: {$code}")
                    ->danger()
                    ->duration(10000)
                    ->send();
            } else {
                Notification::make()
                    ->title('❌ Pembayaran Non-Tunai Gagal')
                    ->body("Nama: {$name}\nKode Transaksi: {$code}")
                    ->danger()
                    ->duration(10000)
                    ->send();
            }
        }
    }
}
