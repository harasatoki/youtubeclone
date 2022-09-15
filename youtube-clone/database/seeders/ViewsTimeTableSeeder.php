<?php

namespace Database\Seeders;

use App\Models\ViewsTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViewsTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 20; $i++){
            ViewsTime::create([
                'movie_id' => $i,
                'views_time' => 0
            ]);
        }
    }
}
