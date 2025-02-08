<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'users_id',
        'goods_id'
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}