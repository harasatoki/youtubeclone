<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentOnComment;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class OverheadProcessingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = new User();
        $follow = new Follow();
        $comment = new Comment();
        $commentOnComment = new CommentOnComment();

        if(Auth::check()){
            $loginUserId = auth()->id();
            $nowUserId = $loginUserId;
        }else{
            $guestUserId = 1;
            $nowUserId = $guestUserId;
        }

        $followingUsersId = $follow->fetchUserFollowing($nowUserId);
        $followingUsers = collect([]);
        foreach( $followingUsersId as $followingUserId ){
            $followingUser = $user->fetchUser($followingUserId->followed_id);
            $followingUsers = $followingUsers->concat([$followingUser]);
        }

        $commentIds = $comment->fetchNowUserCommentIds($nowUserId);
        $noticeComments = $commentOnComment->noticeComment($commentIds);
        $request->merge([
            'nowUserId' => $nowUserId,
            'followingUsers' => $followingUsers,
            'noticeComments' => $noticeComments
        ]);

        return $next($request);
    }
}
