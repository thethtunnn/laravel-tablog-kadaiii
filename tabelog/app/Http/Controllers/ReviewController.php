<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Store $store, Request $request)
    {
        Review::insert([
            'user_id' => Auth::user()->id,
            'store_id' => $store->id,
            'content' => $request->content,

        ]);
        return redirect()->back();
    }

    public function edit(Review $review)
    {
        return view('meals.edit-review', compact('review'));
    }
    public function update(Request $request)
    {
        $review = Review::where('id', $request->review_id)->first();
        // dd($review);
        $review->content = $request->content;
        $review->update();

        return redirect()->route('meals.show', $review->store_id);
    }

    public function delete(Review $review)
    {
        $review->delete();
        return redirect()->back();
    }
}
