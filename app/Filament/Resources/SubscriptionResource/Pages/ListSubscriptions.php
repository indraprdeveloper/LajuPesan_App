<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Langganan'),
        ];
    }

    protected function getListeners(): array
    {
        $storeId = Auth::id();

        $listeners = [
            "echo:store.{$storeId},SubscriptionPaymentUpdated" => '$refresh',
        ];

        if (Auth::user()->role === 'admin') {
            $listeners["echo:admin,SubscriptionCreated"] = '$refresh';
        }

        return $listeners;
    }
}
