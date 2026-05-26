<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class StoreProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Manajemen Profil Toko';
    protected static ?string $title = 'Manajemen Profil Toko';
    protected static ?string $slug = 'profil-toko';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.store-profile';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Auth::user()->role === 'store';
    }

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->form->fill([
            'logo' => $user->logo,
            'address' => $user->address,
            'google_maps_link' => $user->google_maps_link,
            'phone' => $user->phone,
            'opening_hours' => $user->opening_hours,
            'closing_hours' => $user->closing_hours,
            'storeSocialMedia' => $user->storeSocialMedia->map(function ($social) {
                return [
                    'platform' => $social->platform,
                    'url' => $social->url,
                ];
            })->toArray(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Toko')
                    ->description('Kelola informasi dasar toko Anda.')
                    ->icon('heroicon-o-building-storefront')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Toko')
                            ->image()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('google_maps_link')
                            ->label('Link Google Maps')
                            ->url()
                            ->prefix('https://')
                            ->placeholder('maps.google.com/...')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->placeholder('08xxxxxxxxxx'),
                    ])->columns(2),

                Forms\Components\Section::make('Jam Operasional')
                    ->description('Tentukan jam buka dan tutup toko Anda.')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Forms\Components\TimePicker::make('opening_hours')
                            ->label('Jam Buka')
                            ->seconds(false)
                            ->required(),
                        Forms\Components\TimePicker::make('closing_hours')
                            ->label('Jam Tutup')
                            ->seconds(false)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Sosial Media')
                    ->description('Tambahkan akun sosial media toko Anda. Klik tombol + untuk menambah lebih dari satu.')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        Forms\Components\Repeater::make('storeSocialMedia')
                            ->label('')
                            ->schema([
                                Forms\Components\Select::make('platform')
                                    ->label('Platform')
                                    ->options([
                                        'instagram' => 'Instagram',
                                        'facebook' => 'Facebook',
                                        'tiktok' => 'TikTok',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('url')
                                    ->label('Link / URL')
                                    ->url()
                                    ->required()
                                    ->placeholder('https://...'),
                            ])
                            ->columns(2)
                            ->addActionLabel('+ Tambah Sosial Media')
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'logo' => $data['logo'],
            'address' => $data['address'],
            'google_maps_link' => $data['google_maps_link'],
            'phone' => $data['phone'],
            'opening_hours' => $data['opening_hours'],
            'closing_hours' => $data['closing_hours'],
        ]);

        // Sync social media
        $user->storeSocialMedia()->delete();

        if (!empty($data['storeSocialMedia'])) {
            foreach ($data['storeSocialMedia'] as $social) {
                $user->storeSocialMedia()->create([
                    'platform' => $social['platform'],
                    'url' => $social['url'],
                ]);
            }
        }

        Notification::make()
            ->title('Profil toko berhasil diperbarui!')
            ->success()
            ->send();
    }
}
