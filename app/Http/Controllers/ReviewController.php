<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //add_viewページに関する記述

    public function add_view(Post $post)
    {
        return view('add_view', compact('post'));
    }

    public function add_view_store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'rating' => 'required|numeric|between:1, 5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $existReview = Review::where('user_id', Auth::id())->where('post_id', $post->id)->exists();

        if ($existReview) {
            session()->flash('error', 'Your Review Has Already Been Added!');
            return redirect()->back()->withInput();
        }

        $review = new Review();

        $review->post_id = $post->id;
        $review->user_id = Auth::id();
        $review->rating = $request->input('rating');
        $review->title = $request->input('title');
        $review->description = $request->input('description');
        $review->save();

        return redirect()
            ->route('user.view_post', ['post' => $post])
            ->with('success', 'Review Added!');
    }

    //edit_reviewページに関する記述

    public function edit_review(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('edit_review', compact('review'));
    }

    public function edit_review_update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'rating' => 'nullable|numeric|between:1, 5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $review->title = $request->input('title');
        $review->description = $request->input('description');
        $review->rating = $request->input('rating');
        $review->save();

        return redirect()
            ->route('user.view_post', ['post' => $review->post_id, 'page' => request('page')])
            ->with('success', 'Review Updated!');
    }

    public function view_post_destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        session()->flash('success', 'Review Deleted Successfully!');

        return redirect()->back();
    }
}
