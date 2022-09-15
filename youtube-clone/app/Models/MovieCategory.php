<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * マスターカテゴリーリレーション
     * 
     * @return void
     */
    public function masterMovieCategory(){
        return $this->belongsTo(MasterMovieCategory::class , 'movie_category_id');
    }

    /**
     * 動画のカテゴリーからおすすめ用のカテゴリーリストを作成
     *
     * @param int $movieId
     * 
     * @return array
     */
    public function fetchMovieCategorys($movieId){
        $movieCategorysId = $this->where('movie_id', $movieId)->get();
        $tenMovieCategorysId = collect([]);
        $i=0;
        while($i<=9){
            foreach($movieCategorysId as $movieCategoryId){
                $tenMovieCategorysId = $tenMovieCategorysId->concat([$movieCategoryId->movie_category_id]);
                $i++;
            }
        }
        return $tenMovieCategorysId;
    }
}
