<?php

namespace Database\Seeders;

use App\Models\MovieCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <=20; $i++){
            MovieCategory::create([
                'movie_id' => $i,
                'movie_category_id' => $i%6+1
            ]);
        }
    }
}
