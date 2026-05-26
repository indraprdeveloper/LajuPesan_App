<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;



class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $slug = 'langganan';

    protected static ?string $navigationLabel = 'Langganan';
    protected static ?string $pluralModelLabel = 'Langganan';
     protected static ?string $modelLabel = 'Langganan';

    public static function canCreate(): bool
    {
        return Auth::user()->role !== 'admin';
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('user_id', $user->id);
    }
    public static function canEdit(Model $record): bool
    {
        return Auth::user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Toko')
                    ->options(User::all()->pluck('name', 'id')->toArray())
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'),

                Forms\Components\Repeater::make('subscriptionPayment')
                    ->relationship()
                    ->label('Pembayaran Langganan')
                    ->schema([
                        Forms\Components\FileUpload::make('proof')
                            ->label('Bukti Transfer Ke Rekening 5920185705 (BCA) A/N INDRA PRIMA RAMADANI Sebesar Rp. 50.000')
                            ->required()
                            ->columnSpanFull()
                            ->openable()
                            ->downloadable()
                            ->deletable(false),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Menunggu',
                                'success' => 'Berhasil',
                                'failed' => 'Gagal'
                            ])
                            ->required()
                            ->label('Status Pembayaran')
                            ->columnSpanFull()
                            ->hidden(fn() => Auth::user()->role === 'store'),
                    ])
                    ->columnSpanFull()
                    ->addable(false)
                    ->deletable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->label('Tanggal Mulai'),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('M d, Y H:i')
                    ->label('Tanggal Berakhir'),
                Tables\Columns\ImageColumn::make('subscriptionPayment.proof')
                    ->label('Bukti Pembayaran'),
                Tables\Columns\TextColumn::make('subscriptionPayment.status')
                    ->dateTime()
                    ->label('Status Pembayaran'),
                Tables\Columns\TextColumn::make('subscriptionPayment.status')
                    ->label('Status Pembayaran')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'success' => 'Berhasil',
                        'failed' => 'Gagal',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
