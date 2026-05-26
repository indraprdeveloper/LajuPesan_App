<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Filters\SelectFilter;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Manajemen Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $slug = 'transaksi';

    public static function canCreate(): bool
    {
        return false;
    }


    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('user_id', $user->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->required()
                    ->reactive()
                    ->hidden(fn() => Auth::user()->role === 'store')
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('code')
                    ->label('Kode Transaksi')
                    ->default(fn(): string => 'TRX-' . mt_rand(10000, 99999))
                    ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor Telepon')
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('table_number')
                    ->label('Nomer Meja')
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Tunai',
                        'midtrans' => 'Non Tunai'
                    ])
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\Select::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Tertunda',
                        'success' => 'Berhasil',
                        'failed' => 'Gagal'
                    ])
                    ->required(),

                Forms\Components\Repeater::make('transactionDetails')
                    ->label('Detail Transaksi')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'name')
                            ->options(function (callable $get) {
                                if (Auth::user()->role === 'admin') {
                                    return Product::all()->mapWithKeys(function ($product) {
                                        return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"];
                                    });
                                }
                                return Product::where('user_id', Auth::user()->id)->get()->mapWithKeys(function ($product) {
                                    return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"];
                                });
                            })
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1),
                        Forms\Components\TextInput::make('note')
                            ->label('Catatan'),
                    ])->columnSpanFull()
                    ->addActionLabel('Tambahkan ke Detail Transaksi')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    })
                    ->reorderable(false)
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('total_price')
                    ->label('Total Harga')
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Transaksi'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggan'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Nomor Telepon'),
                Tables\Columns\TextColumn::make('table_number')
                    ->label('Nomer Meja'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cash' => 'Tunai',
                        'midtrans' => 'Non Tunai',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Pembayaran')
                    ->formatStateUsing(function (string $state) {
                        return 'Rp' . number_format($state);
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Pembayaran')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Tertunda',
                        'success' => 'Berhasil',
                        'failed' => 'Gagal',
                        default => $state,
    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime('M d, Y H:i'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->label('Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => in_array($record->status, ['success', 'failed']) || $record->payment_method === 'midtrans'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->status === 'failed'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ])
            ->recordUrl(fn ($record) => $record->status === 'pending' && $record->payment_method !== 'midtrans'
                ? TransactionResource::getUrl('edit', ['record' => $record])
                : null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $selectedProducts = \collect($get('transactionDetails'))
            ->filter(
                fn($item) =>
                !empty($item['product_id']) &&
                    !empty($item['quantity'])
            );

        // ambil harga produk berdasarkan id
        $prices = Product::whereIn(
            'id',
            $selectedProducts->pluck('product_id')
        )->pluck('price', 'id');

        // hitung total transaksi
        $total = $selectedProducts->reduce(function ($total, $product) use ($prices) {
            return $total + (
                ($prices[$product['product_id']] ?? 0) * $product['quantity']
            );
        }, 0);

        $set('total_price', (string) $total);
    }
}
