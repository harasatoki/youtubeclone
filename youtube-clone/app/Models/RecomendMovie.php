<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recomendMovie extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'entertainment',
        'education',
        'music',
        'animal',
        'streamer',
        'society'
    ];

    /**
     * ログイン者の視聴したカテゴリーの回数からおすすめ動画のカテゴリーリストをランダムで作成
     *
     * @param int $nowUserId
     * 
     * @return array
     */
    public function fetchRecomendCategoryIds($nowUserId)
    {
        $categoryRatio = $this->where('user_id', $nowUserId)->first();
        $entertainment  = $categoryRatio->entertainment;
        $education      = $categoryRatio->education;
        $music          = $categoryRatio->music;
        $animal         = $categoryRatio->animal;
        $streamer       = $categoryRatio->streamer;
        $society        = $categoryRatio->society;
        $allTimes       = $entertainment+$education+$music+$animal+$streamer+$society;

        $fetchRecomendCategorys = collect([]);
        for($i = 0; $i <=10; $i++){
            $decidCategory      = mt_rand(1,$allTimes);
            $decidCategory      -= $entertainment;
            $end            = 0;
            if($decidCategory<=0){
                $fetchRecomendCategory = 1;
                $end        = 1;
            }
            $decidCategory     -= $education;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = 2;
                $end        = 1;
            }
            $decidCategory     -= $music;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = 3;
                $end        = 1;
            }
            $decidCategory     -= $animal;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = 4;
                $end        = 1;
            }
            $decidCategory     -= $streamer;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = 5;
                $end        = 1;
            }
            $decidCategory      -= $society;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = 6;
            }
            $fetchRecomendCategorys = $fetchRecomendCategorys->concat([$fetchRecomendCategory]);
        }

        return $fetchRecomendCategorys;
    }
}
