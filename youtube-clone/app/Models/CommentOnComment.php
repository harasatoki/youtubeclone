<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentOnComment extends Model
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
        return $this->belongsTo(User::class, 'user_id');
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
            $noticeComment = $this->with('user')->where('comment_id', $commentId->id)->get();
            $noticeComments = $noticeComments->concat($noticeComment);
        }
        return $noticeComments; 
    }
}
