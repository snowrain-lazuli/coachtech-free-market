<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\Image;
use App\Models\User;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'id' => 1,
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'img_url' => 'storage/' . 'Armani+Mens+Clock.jpg'
        ];
    }
}