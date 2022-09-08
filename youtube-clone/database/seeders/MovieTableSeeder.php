<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2; $i <= 11; $i++){
            Movie::create([
                'user_id'           => $i,
                'movie'             => 'test.MP4',
                'thumbnails_image'  => 'test.png',
                'movie_title'       => 'test update'.$i,
                'movie_outline'     => 'これはテスト投稿です',
                'type1'            => 'entertainment',
                'type2'            => 'education',
                'type3'            => 'music',
                'created_at'        => now(),
                'updated_at'        => now()
            ]);
        }
        for($i = 12; $i <= 21; $i++){
            Movie::create([
                'user_id'           => $i-10,
                'movie'             => 'test.MP4',
                'thumbnails_image'  => 'test.png',
                'movie_title'       => 'test update'.$i,
                'movie_outline'     => 'これはテスト投稿です',
                'type1'            => 'animal',
                'type2'            => 'streamer',
                'type3'            => 'society',
                'created_at'        => now(),
                'updated_at'        => now()
            ]);
        }
    }
}