<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductIngredient;


class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_category_id',
        'image',
        'name',
        'description',
        'price',
        'is_popular'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (Auth::user()->role === 'store') {
                $model->user_id = Auth::user()->id;
            }
        });
        static::updating(function ($model) {

            if (Auth::user()->role === 'store') {
                $model->user_id = Auth::user()->id;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productIngredients()
{
    return $this->hasMany(ProductIngredient::class);
}

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Hitung rata-rata rating dari review customer
    public function getAverageRatingAttribute()
    {
        $avg = $this->productReviews()->avg('rating');
        return $avg ? round($avg, 1) : 0;
    }
}
