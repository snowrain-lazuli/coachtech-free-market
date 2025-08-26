<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                [
                    'user_id' => 1,
                    'name' => '腕時計',
                    'condition' => '1',
                    'details' => 'スタイリッシュなデザインのメンズ腕時計',
                    'price' => '15000',
                    'brand' => 'とけい',
                ],
                [
                    'user_id' => 1,
                    'name' => 'HDD',
                    'condition' => '2',
                    'details' => '高速で信頼性の高いハードディスク',
                    'price' => '5000',
                    'brand' => 'でぃすく',
                ],
                [
                    'user_id' => 1,
                    'name' => '玉ねぎ3束',
                    'condition' => '3',
                    'details' => '新鮮な玉ねぎ3束のセット',
                    'price' => '300',
                    'brand' => 'たべもの',
                ],
                [
                    'user_id' => 1,
                    'name' => '革靴',
                    'condition' => '4',
                    'details' => 'クラシックなデザインの革靴',
                    'price' => '4000',
                    'brand' => 'くつ',
                ],
                [
                    'user_id' => 1,
                    'name' => 'ノートPC',
                    'condition' => '1',
                    'details' => '高性能なノートパソコン',
                    'price' => '45000',
                    'brand' => 'PC',
                ],
                [
                    'user_id' => 2,
                    'name' => 'マイク',
                    'condition' => '2',
                    'details' => '高音質のレコーディング用マイク',
                    'price' => '8000',
                    'brand' => 'シュアー',
                ],
                [
                    'user_id' => 2,
                    'name' => 'ショルダーバッグ',
                    'condition' => '3',
                    'details' => 'おしゃれなショルダーバッグ',
                    'price' => '3500',
                    'brand' => 'ばっぐ',
                ],
                [
                    'user_id' => 2,
                    'name' => 'タンブラー',
                    'condition' => '4',
                    'details' => '使いやすいタンブラー',
                    'price' => '500',
                    'brand' => 'すたば',
                ],
                [
                    'user_id' => 2,
                    'name' => 'コーヒーミル',
                    'condition' => '1',
                    'details' => '手動のコーヒーミル',
                    'price' => '4000',
                    'brand' => 'たりーず',
                ],
                [
                    'user_id' => 2,
                    'name' => 'メイクセット',
                    'condition' => '2',
                    'details' => '便利なメイクアップセット',
                    'price' => '2500',
                    'brand' => '資生堂',
                ]
            ]
        );
    }
}