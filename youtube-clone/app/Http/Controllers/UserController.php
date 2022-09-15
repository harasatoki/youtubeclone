<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentOnComment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Follow;
use App\Models\recomendMovie;

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
    public function home(Request $request, Movie $movie, recomendMovie $recomendMovie)
    {
        $recomendCategoryIds = $recomendMovie->fetchRecomendCategoryIds($request->nowUserId);
        $recomendMovies = $movie->fetchMoviesFromCategoryIds($recomendCategoryIds);

        return view('users.home',[
            "nowUser" => $request->nowUserId,
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

        $followingUsersIdByViewedUser = $follow->fetchUserFollowing($user->id);
        $followingUsersByViewedUser = collect([]);
        foreach( $followingUsersIdByViewedUser as $followingUserIdByViewedUser ){
            $followingUserByViewedUser = $user->fetchUser($followingUserIdByViewedUser->followed_id);
            $followingUsersByViewedUser = $followingUsersByViewedUser->concat([$followingUserByViewedUser]);
        }

        return view('users.channelFollow', [
            "user" => $user,
            "nowUser" => $request->nowUserId,
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
            "nowUser" => $request->nowUserId,
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
            "nowUser" => $request->nowUserId,
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
            "fetchUserFollowedCount" => $followerCountOfViewedUser
        ]);
    }

    //以下、今後使用する可能性があるためコントローラー作成完了時に削除予定
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
