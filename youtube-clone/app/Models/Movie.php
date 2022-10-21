<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie',
        'thumbnails_image',
        'movie_title',
        'movie_outline',
        'type1',
        'type2',
        'type3',
    ];

    /**
     * ユーザーリレーション
     *
     * @return void
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * ムービーカテゴリーリレーション
     *
     * @return void
     */
    public function movieCategory(){
        return $this->hasMany(MovieCategory::class);
    }

    /**
     * 視聴履歴のリレーション
     *
     * @return void
     */
    public function viewsTimes(){
        return $this->hasOne(ViewsTime::class);
    }

    /**
     * カテゴリーリストから動画を取得
     *
     * @param array $categoryIds
     * 
     * @return array
     */
    public function fetchMoviesFromCategoryIds($categoryIds){
        $recomendMovies = collect([]);
        $testlist = array();
        foreach($categoryIds as $categoryId){
            $i=0;
            while($i<=5){
                $recomendMovie = $this
                    ->inRandomOrder()
                    ->with('user')
                    ->with('movieCategory')
                    ->with('viewstimes')
                    ->whereHas('movieCategory',function($fhechMovieCategoryId)use($categoryId){
                        $fhechMovieCategoryId->where('movie_category_id', $categoryId);
                    })
                    ->first();
                    if(!in_array($recomendMovie->id, $testlist)){
                        $recomendMovies = $recomendMovies->concat([$recomendMovie]);
                        $testlist[] = $recomendMovie->id;
                    }
                    $i++;
                }
        }
    
        return $recomendMovies;
    }

    /**
     * ユーザーの投稿動画を取得
     *
     * @param int $userId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchPostedVideo($userId)
    {
        return $this->with('user')->with('viewstimes')->where('user_id', $userId)->get();
    }

    public function fetchMovieEdit($movieId)
    {
        $this->where('id', $movieId)->first();
    }

    // public function updateMovie($movie, $data){

    // }

    public function destroyMovie($movieId){
        $this->where('id', $movieId)->delete();
    }

    public function fetchMovieLog($viewsLogIds){
        $movieLogs = collect([]);
        foreach($viewsLogIds as $viewsLogId){
            $movieLog = $this->where('id', $viewsLogId->movie_id)->first();
            $movieLogs = $movieLogs->concat([$movieLog]);
        }
        return $movieLogs;
    }
}
