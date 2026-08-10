<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['title', 'image'];

    // reviewsテーブルとのリレーション関係
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
