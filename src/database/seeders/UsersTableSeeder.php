<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // 固定ユーザー id=1
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'TestUser1',
            'email' => 'test1@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ダミーユーザー id=2,3
        DB::table('users')->insert([
            [
                'name' => 'TestUser2',
                'email' => 'test2@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TestUser3',
                'email' => 'test3@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}