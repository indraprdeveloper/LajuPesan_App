<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Subscription extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'end_date',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
            
            $model->end_date = now()->addDays(30);
        });

        static::created(function ($model) {
            \App\Events\SubscriptionCreated::dispatch($model);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPayment()
    {
        return $this->hasOne(SubscriptionPayment::class);
    }
}
