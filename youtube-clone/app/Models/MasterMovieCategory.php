<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMovieCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * ムービーカテゴリーのリレーション
     *
     * @return void
     */
    public function movieCategory(){
        return $this->belongsToMany(MovieCategory::class);
    }
}
