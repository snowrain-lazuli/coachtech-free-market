<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ItemCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        $categories = Category::all();

        foreach ($items as $item) {
            $randomCategories = $categories->random(rand(1, 3));

            $item->categories()->attach($randomCategories);
        }
    }
}