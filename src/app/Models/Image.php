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
            // user_id と item_id の片方が必ずnullであることをチェック
            if (!((!$image->user_id && $image->item_id) || (!$image->item_id && $image->user_id))) {
                throw new \Exception('user_id または item_id のいずれか一方は必ずnullでなければなりません。');
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