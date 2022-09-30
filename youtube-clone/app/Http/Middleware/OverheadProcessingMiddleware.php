<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class OverheadProcessingMiddleware
{
    private const GUEST_USER_ID = 1;

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

        if(Auth::check()){
            $loginUserId = auth()->id();
            $targetUserId = $loginUserId;
        }else{
            $targetUserId = self::GUEST_USER_ID;
        }

        $followingUserIds = $follow->fetchUserFollowing($targetUserId);
        $followingUsers = collect([]);
        foreach( $followingUserIds as $followingUserId ){
            $followingUser = $user->fetchUser($followingUserId->followed_id);
            $followingUsers = $followingUsers->concat([$followingUser]);
        }

        $commentIds = $comment->fetchTargetUserCommentIds($targetUserId);
        $noticeComments = $comment->noticeComment($commentIds);
        $request->merge([
            'targetUserId' => $targetUserId,
            'followingUsers' => $followingUsers,
            'noticeComments' => $noticeComments
        ]);

        return $next($request);
    }
}
