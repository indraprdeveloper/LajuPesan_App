<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'phone_number',
        'table_number',
        'payment_method',
        'total_price',
        'status',
        'is_rated'
    ];

    protected $casts = [
        'is_rated' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (Auth::user()?->role === 'store') {
                $model->user_id = Auth::user()->id;
            }
        });
        static::updating(function ($model) {

            if (Auth::user()?->role === 'store') {
                $model->user_id = Auth::user()->id;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
