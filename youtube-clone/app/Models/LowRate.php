<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * 動画についた低評価の数を取得
     *
     * @param int $movieId
     * 
     * @return int
     */
    public function fetchMovieLowLateCount($movieId){
        return $this->where('movie_id', $movieId)->count();
    }

    /**
     * 使用者が動画に低評価しているか
     *
     * @param int $userId
     * @param int $movieId
     * 
     * @return boolean
     */
    public function isLowRate($userId, $movieId){
        return $this->where('user_id', $userId)->where('movie_id', $movieId)->exists();
    }

    public function storeLowRate($loginUserId, $movieId){
        $this->user_id = $loginUserId;
        $this->movie_id = $movieId;
        $this->save();
    }

    public function deleteLowRate($loginUserId, $movieId){
        $this->where('user_id', $loginUserId)->where('movie_id', $movieId)->delete();
    }
}
