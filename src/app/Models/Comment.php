<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comments',
    ];
    protected $guarded = [
        'id',
        'user_id',
        'goods_id',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}