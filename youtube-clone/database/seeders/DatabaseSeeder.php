<?php

namespace Database\Seeders;

use App\Models\recomendMovie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            MovieTableSeeder::class,
            CommentTableSeeder::class,
            FollowTableSeeder::class,
            HighRateTableSeeder::class,
            LowRateTableSeeder::class,
            ViewsLogTableSeeder::class,
            RecomendMoviesTableSeeder::class,
            CommentOnCommentTableSeeder::class,
            MovieCategoryTableSeeder::class,
            MasterMovieCategoryTableSeeder::class
        ]);
    }
}
