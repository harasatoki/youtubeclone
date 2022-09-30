<?php

namespace Database\Seeders;

use App\Models\MasterMovieCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterMovieCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movie_categorys = [
            'entertainment',
            'education',
            'music',
            'animal',
            'streamer',
            'society'
        ];
        foreach($movie_categorys as $movie_category){
            MasterMovieCategory::create([ 'movie_category' => $movie_category ]);
        }
    }
}
