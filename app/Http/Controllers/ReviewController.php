<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        $product = Product::findOrFail($productId);
        // Any user can submit reviews for any product
        Review::updateOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ], [
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return back()->with('success', 'Review submitted!');
    }
}
