<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewsLog extends Model
{
    use HasFactory;

    protected $table = 'views_log';

    /**
     * 100回まで視聴履歴を保存
     *
     * @param [type] $loginUserId
     * @param [type] $movieId
     * @return void
     */
    public function storeViewsLog($loginUserId, $movieId){
        if($this->where('user_id', $loginUserId)->count()>=100){
            $this->where('created_at',$this->min('created_at'))->delete();
        }
        $this->user_id = $loginUserId;
        $this->movie_id = $movieId;
        $this->created_at = now();
        $this->updated_at = now();
        $this->save();
    }

    public function fetchViewsLogIds($targetUserId){
        return $this->where('user_id', $targetUserId)->latest('created_at')->get('movie_id');
    }
}
