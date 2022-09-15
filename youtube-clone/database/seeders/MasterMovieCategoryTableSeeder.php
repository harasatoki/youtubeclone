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
        MasterMovieCategory::create([
            'movie_category' => 'entertainment',
        ]);
        MasterMovieCategory::create([
            'movie_category' => 'education',
        ]);
        MasterMovieCategory::create([
            'movie_category' => 'music',
        ]);
        MasterMovieCategory::create([
            'movie_category' => 'animal',
        ]);
        MasterMovieCategory::create([
            'movie_category' => 'streamer',
        ]);
        MasterMovieCategory::create([
            'movie_category' => 'society'
        ]);
    }
}
