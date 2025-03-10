<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            [
                'user_id' => null,
                'item_id' => '1',
                'img_url' => 'storage/Armani+Mens+Clock.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '2',
                'img_url' => 'storage/HDD+Hard+Disk.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '3',
                'img_url' => 'storage/iLoveIMG+d.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '4',
                'img_url' => 'storage/Leather+Shoes+Product+Photo.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '5',
                'img_url' => 'storage/Living+Room+Laptop.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '6',
                'img_url' => 'storage/Music+Mic+4632231.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '7',
                'img_url' => 'storage/Purse+fashion+pocket.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '8',
                'img_url' => 'storage/Tumbler+souvenir.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '9',
                'img_url' => 'storage/Waitress+with+Coffee+Grinder.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '10',
                'img_url' => 'storage/外出メイクアップセット.jpg',
            ],
            [
                'user_id' => '1',
                'item_id' => null,
                'img_url' => 'storage/boy_01.png',
            ],
            [
                'user_id' => '2',
                'item_id' => null,
                'img_url' => 'storage/boy_02.png',
            ],
            [
                'user_id' => '3',
                'item_id' => null,
                'img_url' => 'storage/boy_07.png',
            ],
            [
                'user_id' => '4',
                'item_id' => null,
                'img_url' => 'storage/boy_08.png',
            ],
            [
                'user_id' => '5',
                'item_id' => null,
                'img_url' => 'storage/girl_14.png',
            ],
            [
                'user_id' => '6',
                'item_id' => null,
                'img_url' => 'storage/girl_18.png',
            ],
            [
                'user_id' => '7',
                'item_id' => null,
                'img_url' => 'storage/girl_19.png',
            ],
            [
                'user_id' => '8',
                'item_id' => null,
                'img_url' => 'storage/girl_23.png',
            ],
            [
                'user_id' => '9',
                'item_id' => null,
                'img_url' => 'storage/youngman_34.png',
            ],
            [
                'user_id' => '10',
                'item_id' => null,
                'img_url' => 'storage/youngwoman_44.png',
            ],
        ]);
    }
}