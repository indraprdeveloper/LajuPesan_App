<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSocialMedia extends Model
{
    protected $table = 'store_social_media';

    protected $fillable = [
        'user_id',
        'platform',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
