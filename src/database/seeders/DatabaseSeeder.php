<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(ItemCategoriesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
    }
}