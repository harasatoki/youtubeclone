<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Follow;
use App\Models\RecomendMovie;

class UserController extends Controller
{
    /**
     * コントローラーの共通処理のミドルウェア
     */
    public function __construct()
    {
        $this->middleware('overheadProcess');
    }
    /**
     * ホーム画面
     *
     * @param Request $request
     * @param Movie $movie
     * @param recomendMovie $recomendMovie
     * 
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request, Movie $movie, RecomendMovie $recomendMovie)
    {
        $recomendCategoryIds = $recomendMovie->fetchRecomendCategoryIds($request->targetUserId);
        $recomendMovies = $movie->fetchMoviesFromCategoryIds($recomendCategoryIds);

        return view('users.home',[
            "targetser" => $request->targetUserId,
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
            "recomendMovies" => $recomendMovies
        ]);
    }

    /**
     * ユーザー詳細情報とチャンネル登録者一覧
     *
     * @param Request $request
     * @param User $user
     * @param Follow $follow
     * 
     * @return \Illuminate\Http\Response
     */
    public function channelFollow(Request $request, User $user, Follow $follow){
        $followerCountOfViewedUser = $follow->fetchUserFollowedCount($user->id);

        $followingUserIdsByViewedUser = $follow->fetchUserFollowing($user->id);
        $followingUsersByViewedUser = collect([]);
        foreach( $followingUserIdsByViewedUser as $followingUserIdByViewedUser ){
            $followingUserByViewedUser = $user->fetchUser($followingUserIdByViewedUser->followed_id);
            $followingUsersByViewedUser = $followingUsersByViewedUser->concat([$followingUserByViewedUser]);
        }

        return view('users.channelFollow', [
            "user" => $user,
            "targetUser" => $request->targetUserId,
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
            "followingUsersByViewedUser" => $followingUsersByViewedUser,
            "fetchUserFollowedCount" => $followerCountOfViewedUser
        ]);
    }

    /**
     * ユーザー詳細情報と動画一覧
     *
     * @param Request $request
     * @param User $user
     * @param Movie $movie
     * @param Follow $follow
     * 
     * @return \Illuminate\Http\Response
     */
    public function channelMovie(Request $request, User $user, Movie $movie, Follow $follow){
        $followerCountOfViewedUser = $follow->fetchUserFollowedCount($user->id);
        $fetchPostedVideo = $movie->fetchPostedVideo($user->id);

        return view('users.channelMovie',[
            "user" => $user,
            "targetUser" => $request->targetUserId,
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
            "fetchUserFollowedCount" => $followerCountOfViewedUser,
            "fetchPostedVideo" => $fetchPostedVideo
        ]);
    }

    /**
     * ユーザー詳細情報とチャンネル概要
     *
     * @param Request $request
     * @param User $user
     * @param Follow $follow
     * 
     * @return \Illuminate\Http\Response
     */
    public function channelOverView(Request $request, User $user, Follow $follow){
        $followerCountOfViewedUser = $follow->fetchUserFollowedCount($user->id);

        return view('users.channelOverView',[
            "user" => $user,
            "targetUser" => $request->targetUserId,
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
            "fetchUserFollowedCount" => $followerCountOfViewedUser
        ]);
    }

    /**
     * ユーザー編集
     *
     * @param  User $user
     * 
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        if($user->id == auth()->id()){
            return view('users.edit', ['user' => $user]);
        }else{
            return back();
        }
    }

    public function follow(Request $request, Follow $follow)
    {
        $loginUserId = auth()->id();
        $isFollowing = $follow->isFollowing($loginUserId, $request->input('userId') );

        if(!$isFollowing) {
            $follow->follow($loginUserId, $request->input('userId') );
        }

        return redirect('channel-home');
    }

    public function unfollow(Request $request, Follow $follow)
    {
        $loginUserId = auth()->id();
        $isFollowing = $follow->isFollowing( $loginUserId, $request->input('userId') );

        if( $isFollowing ) {
            $follow->unfollow($loginUserId, $request->input('userId') );
        }

        return redirect('channel-home');
    }

    public function update(Request $request, User $user)
    {
        $userData = $request->all();
        $user->updateProfile( $userData );

        return redirect('channel-home');
    }
}
