<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())->with('product')->get();
        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store($productId)
    {
        Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);
        return redirect()->back()->with('success', 'Product saved for later!');
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $bookmark->delete();
        return redirect()->back()->with('success', 'Bookmark removed.');
    }

    public function addToCart($id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product = $bookmark->product;
        // Add to cart logic
        \App\Models\CartItem::updateOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ], [
            'quantity' => 1
        ]);
        $bookmark->delete();
        return redirect()->route('bookmarks.index')->with('success', 'Product added to cart!');
    }
}
