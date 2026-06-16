<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetakPdf')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->form([
                    Grid::make([
                        'default' => 2,
                    ])
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()->startOfMonth()),
                        DatePicker::make('end_date')
                            ->label('Tanggal Akhir')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),
                    ]),
                    Select::make('user_id')
                        ->label('Toko')
                        ->options(User::where('role', 'store')->pluck('name', 'id'))
                        ->placeholder('Semua Toko')
                        ->searchable()
                        ->visible(fn () => Auth::user()->role === 'admin')
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    $params = [
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date'],
                    ];

                    if (!empty($data['user_id'])) {
                        $params['user_id'] = $data['user_id'];
                    }

                    $url = route('transaksi.cetak-pdf', $params);

                    return redirect($url);
                })
                ->modalHeading('Cetak Laporan Transaksi')
                ->modalDescription('Pilih rentang tanggal untuk mencetak laporan transaksi dalam format PDF.')
                ->modalSubmitAction(fn ($action) => $action->label('Cetak PDF')->icon('heroicon-m-arrow-down-tray'))
                ->modalIcon('heroicon-o-document-arrow-down')
                ->extraModalWindowAttributes(['class' => 'cetak-pdf-modal']),

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
