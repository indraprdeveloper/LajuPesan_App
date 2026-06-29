<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\OtpVerificationMail;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements MustVerifyEmail, HasAvatar, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'logo',
        'name',
        'username',
        'email',
        'password',
        'role',
        'address',
        'google_maps_link',
        'phone',
        'opening_hours',
        'closing_hours',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function boot()
    {
        parent::boot();

        if (!Auth::check()) {
            static::creating(function ($model) {
                $model->role = 'store';
            });
        }
    }

    /**
     * Generate a 6-digit OTP code, hash it, and save to database.
     * Returns the plain OTP code (for sending via email).
     */
    public function generateOtp(): string
    {
        $plainOtp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->otp_code = Hash::make($plainOtp);
        $this->otp_expires_at = now()->addMinutes(10);
        $this->save();

        return $plainOtp;
    }

    /**
     * Verify the given OTP code against the stored hash.
     * Returns true if valid and not expired.
     */
    public function verifyOtp(string $code): bool
    {
        if (!$this->otp_code || !$this->otp_expires_at) {
            return false;
        }

        if ($this->otp_expires_at->isPast()) {
            return false;
        }

        return Hash::check($code, $this->otp_code);
    }

    /**
     * Clear the OTP code and expiry after successful verification.
     */
    public function clearOtp(): void
    {
        $this->otp_code = null;
        $this->otp_expires_at = null;
        $this->save();
    }

    /**
     * Override Laravel's default email verification notification.
     * Instead of sending a link, we generate an OTP and send it via email.
     */
    public function sendEmailVerificationNotification(): void
    {
        $plainOtp = $this->generateOtp();

        Mail::to($this->email)->queue(new OtpVerificationMail($this->name, $plainOtp));
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function storeSocialMedia()
    {
        return $this->hasMany(StoreSocialMedia::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        if (str_starts_with($this->logo, 'assets/')) {
            return asset($this->logo);
        }

        return Storage::url($this->logo);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'store']);
    }
}
