<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * ログイン者がチャンネル登録者した人の取得
     *
     * @param int $userId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchUserFollowing($userId){
        return $this->where('following_id', $userId)->get('followed_id');
    }

    /**
     * ユーザーのチャンネル登録者数を取得
     *
     * @param int $userId
     * 
     * @return int
     */
    public function fetchUserFollowedCount($userId){
        return $this->where('followed_id', $userId)->count();
    }

    /**
     * チャンネル登録をしているか
     *
     * @param int $nowUserId
     * @param int $postedUserId
     * 
     * @return boolean
     */
    public function isFollowing($nowUserId, $postedUserId){
        return $this->where('following_id', $nowUserId)->where('followed_id', $postedUserId)->exists();
    }
}
