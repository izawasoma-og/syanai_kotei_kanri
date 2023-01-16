<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([[
            'name' => 'dog',
            'email' => 'wanwan@example.com',
            'password' => \Hash::make('admin123'),
            'memo' => 'he is dog.',
            'authority_types_id' => '1',
        ],
        [
            'name' => 'cat',
            'email' => 'meowmeow@example.com',
            'password' => \Hash::make('admin123'),
            'memo' => 'she is cat.',
            'authority_types_id' => '1',
        ],
        [
            'name' => 'wolf',
            'email' => 'gawgaw@example.com',
            'password' => \Hash::make('admin123'),
            'memo' => 'he is wolf.',
            'authority_types_id' => '2',
        ]]);
    }
}
