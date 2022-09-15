<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HighRate;

class HighRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2; $i <= 11; $i++){
            if($i%2 == 1){
                for($j = 2; $j <= 11; $j++){
                    HighRate::create([
                        'user_id'   => $i,
                        'movie_id'  => $j
                    ]);
                }
            }
        }
    }
}
