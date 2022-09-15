<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/channel-home', [UserController::class, 'home']);//loginフォーム遷移url設定後にurlを'/'に変更予定
Route::get('/{user}/channelFollow', [UserController::class, 'channelFollow']);
Route::get('/{user}/channelMovie', [UserController::class, 'channelMovie']);
Route::get('/{user}/channelOverView', [UserController::class, 'channelOverView']);
Route::get('/{movie}/movie', [MovieController::class, 'show']);
