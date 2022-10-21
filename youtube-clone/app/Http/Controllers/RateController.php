<?php

namespace App\Http\Controllers;

use App\Models\HighRate;
use App\Models\LowRate;
use Illuminate\Http\Request;

class HighRateController extends Controller
{
    public function storeHighRate(HighRate $highRate, LowRate $lowRate, Request $request){
        $loginUserId = auth()->id();
        $isHighRate = $highRate->isHighRate($loginUserId, $request->input('movieId'));
        $isLowRate = $lowRate->isLowRate($loginUserId, $request->input('movieId'));

        if(!$isHighRate and $isLowRate){
            $highRate->storeHighRate($loginUserId, $request->input('movieId'));
            $lowRate->deleteLowRate($loginUserId, $request->input('movieId'));
        }elseif(!$isHighRate){
            $highRate->storeHighRate($loginUserId, $request->input('movieId'));
        }

        return redirect('channel-home');
    }

    public function storeLowRate(HighRate $highRate, LowRate $lowRate, Request $request){
        $loginUserId = auth()->id();
        $isHighRate = $highRate->isHighRate($loginUserId, $request->input('movieId'));
        $isLowRate = $lowRate->isLowRate($loginUserId, $request->input('movieId'));

        if($isHighRate and !$isLowRate){
            $lowRate->storeLowRate($loginUserId, $request->input('movieId'));
            $highRate->deleteHighRate($loginUserId, $request->input('movieId'));
        }elseif(!$isHighRate){
            $lowRate->storeLowRate($loginUserId, $request->input('movieId'));
        }

        return redirect('channel-home');
    }

    public function deleteHighRate(HighRate $highRate, Request $request){
        $loginUserId = auth()->id();
        $isHighRate = $highRate->isHighRate($loginUserId, $request->input('movieId'));

        if($isHighRate){
            $highRate->deleteHighRate($loginUserId, $request->input('movieId'));
        }

        return redirect('channel-home');
    }
    
    public function deleteLowRate(LowRate $lowRate, Request $request){
        $loginUserId = auth()->id();
        $isLowRate = $lowRate->isLowRate($loginUserId, $request->input('movieId'));

        if($isLowRate){
            $lowRate->deleteLowRate($loginUserId, $request->input('movieId'));
        }

        return redirect('channel-home');
    }
}
