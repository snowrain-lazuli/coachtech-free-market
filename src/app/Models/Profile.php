<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'post_code',
        'address',
        'building',
        'img_id',
        'card_id',
    ];
    protected $guarded = [
        'id',
        'user_id',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function images(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}