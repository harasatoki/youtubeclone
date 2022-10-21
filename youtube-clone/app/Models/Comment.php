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
     * 使用しているユーザーの投稿したコメントのIDを取得
     *
     * @param int $targetUserId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchTargetUserCommentIds($targetUserId){
        return $this->where('user_id', $targetUserId)->where('parent_id', NULL)->get('id');
    }

    /**
     * コメントの通知
     *
     * @param array $commentIds
     * 
     * @return array
     */
    public function noticeComment($commentIds){
        $noticeComments = collect([]);
        foreach( $commentIds as $commentId ){
            $noticeComment = $this->with('user')->where('parent_id', $commentId->id)->get();
            $noticeComments = $noticeComments->concat($noticeComment);
        }
        return $noticeComments; 
    }

    /**
     * 動画についたコメントを取得
     * コメントを投稿時間が早い順に並べるためあえて配列の次元を平坦化
     *
     * @param int $movieId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchCommentTrees($movieId){
        $movieComments = $this->with('user')->where('parent_id', NULL)->where('movie_id', $movieId)->get();
        $commentTrees = collect([]);
        foreach($movieComments as $movieComment){
            $commentTree = collect([]);
            $commentTree = $commentTree->concat([$movieComment]);
            $replyComments = $this->where('parent_id', $movieComment->id)->get();
            foreach($replyComments as $replyComment){
                $commentTree = $commentTree->concat([$replyComment]);
            }
            $commentTrees = $commentTrees->concat([$commentTree]);
        }
        return $commentTrees;
    }
}
