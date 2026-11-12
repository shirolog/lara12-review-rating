<?php

namespace App\Http\Controllers;
use App\Models\Post;

class PostController extends Controller
{
    //all_postsページに関する記述

    public function all_posts()
    {
        $posts = Post::withCount('reviews')->latest()->paginate(6);

        return view('all_posts', compact('posts'));
    }

    //view_postページに関する記述

    public function view_post(Post $post)
    {
        //withCount()と同様にreviews_countを取得できる
        $post ->loadCount('reviews');
        $post->loadSum('reviews', 'rating'); //withSum()と同様にreviews_sum_ratingを取得できる

        if ($post->reviews_count > 0) {
            $average = round($post->reviews_sum_rating / $post->reviews_count, 1);
        } else {
            $average = 0;
        }

        $rating_1 = $post->reviews()->where('rating', 1)->count();
        $rating_2 = $post->reviews()->where('rating', 2)->count();
        $rating_3 = $post->reviews()->where('rating', 3)->count();
        $rating_4 = $post->reviews()->where('rating', 4)->count();
        $rating_5 = $post->reviews()->where('rating', 5)->count();

        $reviews = $post->reviews()->latest()->paginate(10);

        return view('view_post', compact('post', 'average', 'rating_1', 'rating_2', 'rating_3', 'rating_4', 'rating_5', 'reviews'));
    }
}
