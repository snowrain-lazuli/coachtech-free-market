<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];
    protected $guarded = [
        'id',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}