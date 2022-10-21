<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * 動画についた高評価の数を取得
     *
     * @param int $movieId
     * 
     * @return int
     */
    public function fetchMovieHighLateCount($movieId){
        return $this->where('movie_id', $movieId)->count();
    }

    /**
     * 動画に高評価しているか
     *
     * @param int $userId
     * @param int $movieId
     * 
     * @return boolean
     */
    public function isHighRate($userId, $movieId){
        return $this->where('user_id', $userId)->where('movie_id', $movieId)->exists();
    }

    public function storeHighRate($loginUserId, $movieId){
        $this->user_id = $loginUserId;
        $this->movie_id = $movieId;
        $this->save();
    }

    public function deleteHighRate($loginUserId, $movieId){
        $this->where('user_id', $loginUserId)->where('movie_id', $movieId)->delete();
    }
}
