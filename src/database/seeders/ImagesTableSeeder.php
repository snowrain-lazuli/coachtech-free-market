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
                'message_id' => null,
                'img_url' => 'storage/Armani+Mens+Clock.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '2',
                'message_id' => null,
                'img_url' => 'storage/HDD+Hard+Disk.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '3',
                'message_id' => null,
                'img_url' => 'storage/iLoveIMG+d.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '4',
                'message_id' => null,
                'img_url' => 'storage/Leather+Shoes+Product+Photo.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '5',
                'message_id' => null,
                'img_url' => 'storage/Living+Room+Laptop.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '6',
                'message_id' => null,
                'img_url' => 'storage/Music+Mic+4632231.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '7',
                'message_id' => null,
                'img_url' => 'storage/Purse+fashion+pocket.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '8',
                'message_id' => null,
                'img_url' => 'storage/Tumbler+souvenir.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '9',
                'message_id' => null,
                'img_url' => 'storage/Waitress+with+Coffee+Grinder.jpg',
            ],
            [
                'user_id' => null,
                'item_id' => '10',
                'message_id' => null,
                'img_url' => 'storage/外出メイクアップセット.jpg',
            ],
            [
                'user_id' => '1',
                'item_id' => null,
                'message_id' => null,
                'img_url' => 'storage/boy_01.png',
            ],
            [
                'user_id' => '2',
                'item_id' => null,
                'message_id' => null,
                'img_url' => 'storage/boy_02.png',
            ],
            [
                'user_id' => '3',
                'item_id' => null,
                'message_id' => null,
                'img_url' => 'storage/boy_07.png',
            ],
        ]);
    }
}