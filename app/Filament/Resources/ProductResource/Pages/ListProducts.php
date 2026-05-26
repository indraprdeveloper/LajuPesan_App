<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\Product;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        if (Auth::user()->role === 'admin') {
            return [
                Actions\CreateAction::make()
                    ->label('Buat Produk'),
            ];
        }

        $subscription = Subscription::where('user_id', Auth::user()->id)
            ->where('end_date', '>', now())
            ->where('is_active', true)
            ->latest()
            ->first();

        $countProduct = Product::where('user_id', Auth::user()->id)->count();

        return [
            Actions\Action::make('alert')
                ->label('Produk kamu melebihi batas penggunaan gratis, silahkan berlangganan')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle')
                ->visible(!$subscription && $countProduct >= 5),
            Actions\CreateAction::make()
                ->label('Buat Produk'),
        ];
    }

    protected function getListeners(): array
    {
        $storeId = Auth::id();

        return [
            "echo:store.{$storeId},SubscriptionPaymentUpdated" => '$refresh',
        ];
    }
}
