<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'message_id',
        'img_url'
    ];
    protected $guarded = [
        'id',
    ];

    //バリテーション
    public static function boot()
    {
        parent::boot();

        static::creating(function ($image) {
            $filled = [
                'user_id' => !is_null($image->user_id),
                'item_id' => !is_null($image->item_id),
                'message_id' => !is_null($image->message_id),
            ];

            // true の数を数える
            $count = array_filter($filled); // true の数だけ残る
            if (count($count) !== 1) {
                throw new \Exception('user_id、item_id、message_id のうち、どれか1つだけを入力してください。');
            }
        });
    }

    //リレーションの設定
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}