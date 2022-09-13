<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Follow;

class FollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 3; $i <= 11; $i++){
            Follow::create([
                'following_id'  => $i,
                'followed_id'   => 2
            ]);
            Follow::create([
                'following_id'  => 2,
                'followed_id'   => $i
            ]);
        }
    }
}
