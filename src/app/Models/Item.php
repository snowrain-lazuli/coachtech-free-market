<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'detail',
        'condition',
        'img_id',
        'category_id',
        'comment_id',
        'status',
    ];
    protected $guarded = [
        'id',
        'user_id',
    ];

    public function Comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }


    public function Categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}