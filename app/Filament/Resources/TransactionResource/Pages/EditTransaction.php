<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Events\TransactionStatusUpdated;
use Filament\Notifications\Notification;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function beforeFill(): void
    {
        if ($this->getRecord()->payment_method === 'midtrans') {
            Notification::make()
                ->title('Akses Ditolak')
                ->body('Transaksi non-tunai tidak dapat diubah secara manual karena status diperbarui secara otomatis.')
                ->danger()
                ->send();

            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
           //Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        TransactionStatusUpdated::dispatch($this->record);
    }
}
