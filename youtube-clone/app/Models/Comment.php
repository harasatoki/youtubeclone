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
     * @param int $nowUserId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchNowUserCommentIds($nowUserId){
        return $this->where('user_id', $nowUserId)->get('id');
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
