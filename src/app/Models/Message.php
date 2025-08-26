<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'user_id',
        'message',
        'sender',
        'content'
    ];
    protected $guarded = [
        'id',
    ];

    //リレーションの設定
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_categories', 'category_id', 'item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'message_id');
    }

    // app/Models/Message.php
    public function isTransactionCompleted()
    {
        return $this->status === 'completed';
    }
}