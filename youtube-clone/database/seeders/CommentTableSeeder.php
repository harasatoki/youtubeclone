<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentTableSeeder extends Seeder
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
                Comment::create([
                    'user_id'       => $j,
                    'movie_id'      => $i,
                    'text'          => 'テスト動画'.$i.'のテストコメント'.$j,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ]);
            }
        }
    }
}
