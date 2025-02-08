<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\Image;
use App\Models\User;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'id' => 1,
            'name' => '腕時計',
            'price' => '15,000',
            'details' => 'スタイリッシュなデザインのメンズ腕時計',
            'img_id' => Image::factory(),
            'condition' => '1',
            'user_id' => User::factory(),
        ];
    }
}