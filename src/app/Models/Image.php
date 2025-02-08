<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'img_url',
    ];
    protected $guarded = [
        'id',
    ];

    public function profiles(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function images(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}