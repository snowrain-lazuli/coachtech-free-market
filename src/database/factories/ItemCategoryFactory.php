<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ItemCategory;
use App\Models\Item;
use App\Models\Category;
class ItemCategoryFactory extends Factory
{
    protected $model = ItemCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' =>
            Item::inRandomOrder()->first()->id,
            'category_id' =>
            Category::inRandomOrder()->first()->id,
        ];
    }
}