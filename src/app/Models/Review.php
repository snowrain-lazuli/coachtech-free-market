<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'user_id',
        'rating',
    ];

    // リレーション関係
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // 出品者
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // 購入者
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}