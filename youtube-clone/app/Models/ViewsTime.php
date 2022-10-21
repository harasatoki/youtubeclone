<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewsTime extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function storeViewsTime($movieId){
        $this->where('movie_id', $movieId)->increment('views_time');
    }
}
