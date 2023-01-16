<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('operations')->insert([[
            'name' => 'コーディング',
        ],
        [
            'name' => '修正',
        ],
        [
            'name' => 'プログラミング',
        ],
        [
            'name' => '本番アップ',
        ],
        ]);
    }
}
