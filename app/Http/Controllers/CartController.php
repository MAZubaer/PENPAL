<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to your cart.');
        }
        $item = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }
        return redirect()->route('cart.index');
    }

    public function remove(Request $request, Product $product)
    {
        $item = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
        if ($item) {
            $item->delete();
        }
        return redirect()->route('cart.index');
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min=1',
        ]);
        $item = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
        if ($item) {
            $item->quantity = $request->quantity;
            $item->save();
        }
        return redirect()->route('cart.index');
    }

    public function updateAll(Request $request)
    {
        $quantities = $request->input('quantities', []);
        foreach ($quantities as $productId => $qty) {
            $item = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
            if ($item && is_numeric($qty) && $qty > 0) {
                $item->quantity = (int)$qty;
                $item->save();
            }
        }
        return redirect()->route('cart.index');
    }
}
