<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text'
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
     * コメントについた返信のリレーション
     *
     * @return void
     */
    public function commentOnComment(){
        return $this->hasMany(CommentOnComment::class);
    }

    /**
     * 使用しているユーザーの投稿したコメントのIDを取得
     *
     * @param int $targetUserId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchtargetUserCommentIds($targetUserId){
        return $this->where('user_id', $targetUserId)->get('id');
    }

    /**
     * 動画についたコメントを取得
     *
     * @param int $movieId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchComments($movieId){
        return $this->with('user')->with('commentOnComment.user')->where('movie_id', $movieId)->get();
    }
}
