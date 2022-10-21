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

    private const ENTERTAINMENT_ID = 1;
    private const EDUCATION_ID = 2;
    private const MUSIC_ID = 3;
    private const ANIMAL_ID = 4;
    private const STREAMER_ID = 5;
    private const SOCIETY_ID = 6;

    /**
     * ログイン者の視聴したカテゴリーの回数からおすすめ動画のカテゴリーリストをランダムで作成
     *
     * @param int $targetUserId
     * 
     * @return array
     */
    public function fetchRecomendCategoryIds($targetUserId)
    {
        $categoryRatio = $this->where('user_id', $targetUserId)->first();
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
                $fetchRecomendCategory = self::ENTERTAINMENT_ID;
                $end        = 1;
            }
            $decidCategory     -= $education;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = self::EDUCATION_ID;
                $end        = 1;
            }
            $decidCategory     -= $music;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = self::MUSIC_ID;
                $end        = 1;
            }
            $decidCategory     -= $animal;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = self::ANIMAL_ID;
                $end        = 1;
            }
            $decidCategory     -= $streamer;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = self::STREAMER_ID;
                $end        = 1;
            }
            $decidCategory      -= $society;
            if($decidCategory<=0 and $end==0){
                $fetchRecomendCategory = self::SOCIETY_ID;
            }
            $fetchRecomendCategorys = $fetchRecomendCategorys->concat([$fetchRecomendCategory]);
        }

        return $fetchRecomendCategorys;
    }
}
