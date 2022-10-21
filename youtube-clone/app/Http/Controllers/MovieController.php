<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Follow;
use App\Models\HighRate;
use App\Models\LowRate;
use App\Models\Movie;
use App\Models\MovieCategory;
use App\Models\User;
use App\Models\ViewsLog;
use App\Models\ViewsTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * コントローラーの共通処理のミドルウェア
     */
    public function __construct()
    {
        $this->middleware('overheadProcess');
    }

    /**
     * 動画作成画面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        return view('movies.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Movie $movie)
    {
        $userId = auth()->id();
        $movieData = $request->all();
        $movie->storeMovie($userId, $movieData);

        return redirect('channel-home');
    }

    /**
     * 動画画面
     *
     * @param Request $request
     * @param Movie $movie
     * @param User $user
     * @param Follow $follow
     * @param HighRate $highRate
     * @param LowRate $lowRate
     * @param Comment $comment
     * @param MovieCategory $movieCategory
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Movie $movie, User $user, Follow $follow, HighRate $highRate, LowRate $lowRate, Comment $comment, MovieCategory $movieCategory, ViewsLog $viewsLog, ViewsTime $viewsTime)
    {
        $postedUser = $user->fetchUser($movie->user_id);
        $followerCountOfViewedUser = $follow->fetchUserFollowedCount($movie->user_id);
        $movieHighLate = $highRate->fetchMovieHighLateCount($movie->id);
        $isHighRate = $highRate->isHighRate($request->targetUserId, $movie->id);
        $movieLowLate = $lowRate->fetchMovieLowLateCount($movie->id);
        $isLowRate = $lowRate->isLowRate($request->targetUserId, $movie->id);
        $isFollowing = $follow->isFollowing($request->targetUserId, $movie->user_id);
        $commentTrees = $comment->fetchCommentTrees($movie->id);
        $movieCategorys = $movieCategory->fetchMovieCategorys($movie->id);
        $recomendMovie = $movie->fetchMoviesFromCategoryIds($movieCategorys);

        if(Auth::check()){
            $loginUserId = auth()->id();
            $viewsLog->storeViewsLog($loginUserId, $movie->id);
        }
        $viewsTime->storeViewsTime($movie->id);


        return view('movies.movie', [
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
        ]);
    }

    public function viewsLogList(Request $request, ViewsLog $viewsLog, Movie $movie){
        $viewsLogIds = $viewsLog->fetchViewsLogIds($request->targetUserId);
        $viewsLogMovies = $movie->fetchMovieLog($viewsLogIds);

        return view('movies.viewsLog', [
            "followingUsers" => $request->followingUsers,
            "noticeComments" => $request->noticeComments,
            "viewsLogMovies" => $viewsLogMovies
        ]);
    }

    // public function searchMovie(Request $request){
    //     return view('movies.search', [
    //         "followingUsers" => $request->followingUsers,
    //         "noticeComments" => $request->noticeComments,
    //     ]);
    // }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $user = auth()->user();
        $movies = $movie->fetchMovieEdit($movie->id);
        
        return view('movies.edit', [
            'user' => $user,
            'movies' => $movies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $movieData = $request->all();
        $movie->updateMovie($movie->id, $movieData);

        return redirect('channel-home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Movie $movie)
    {
        $loginUserId = auth()->id();
        $movie->destroyMovie($request->input('movieId'));

        return redirect('channel-home');
    }
}
