<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LowRate;

class LowRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2; $i <= 11; $i++){
            for($j = 2; $j <= 11; $j++){
                LowRate::create([
                    'user_id'   => $i,
                    'movie_id'  => $j
                ]);
            }
        }
    }
}
