<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommentOnComment;

class CommentOnCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $k=1;
        for($i = 2; $i <= 11; $i++){
            for($j = 2; $j <= 11; $j++){
                CommentOnComment::create([
                    'user_id'           => $i,
                    'comment_id'        => $k,
                    'text'              => 'テストコメント'.$i.'のテストコメント',
                    'created_at'        => now(),
                    'updated_at'        => now()
                ]);
                $k++;
            }
        }
    }
}
