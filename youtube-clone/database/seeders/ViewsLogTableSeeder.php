<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ViewsLog;

class ViewsLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2; $i <= 11; $i++){
            ViewsLog::create([
                'user_id'   => 2,
                'movie_id'  => $i,
                'created_at'        => now(-$i),
                'updated_at'        => now(-$i)
            ]);
        }
    }
}
