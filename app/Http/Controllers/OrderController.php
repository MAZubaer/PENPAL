<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function input()
    {
        return view('orders.input');
    }
    public function store(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'address' => 'required',
        ]);
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Your cart is empty.');
        }
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        $couponCode = $request->input('coupon_code');
        $discountedTotal = $total;
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)
                ->where('active', true)
                ->where(function($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })->first();
            if ($coupon) {
                if ($coupon->type == 'percent') {
                    $discountedTotal = $total - ($total * ($coupon->value / 100));
                } else {
                    $discountedTotal = max(0, $total - $coupon->value);
                }
            } else {
                $couponCode = null;
            }
        }
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'confirmed',
            'mobile' => $request->mobile,
            'address' => $request->address,
            'coupon_code' => $couponCode,
            'discounted_total' => $discountedTotal,
        ]);
        // Save order items
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('orders.confirmation', $order->id);
    }

    public function confirmation($id)
    {
        $order = Order::with(['orderItems.product'])->findOrFail($id);
        // If you have order_items, count them. Otherwise, count from cart snapshot if stored.
        $order->items_count = $order->orderItems ? $order->orderItems->sum('quantity') : 0;
        return view('orders.confirmation', compact('order'));
    }

    public function adminOrders()
    {
        $orders = Order::with(['user', 'orderItems.product'])->orderBy('created_at', 'desc')->get();
        foreach ($orders as $order) {
            $order->items_count = $order->orderItems ? $order->orderItems->sum('quantity') : 0;
        }
        return view('orders.admin_orders', compact('orders'));
    }

    public function process($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        // Only process if not already processed/cancelled
        if ($order->status !== 'confirmed') {
            return redirect()->back()->withErrors('Order cannot be processed.');
        }
        // Update stock for each product
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                $product->stock = max(0, $product->stock - $item->quantity);
                $product->save();
            }
        }
        $order->status = 'processed';
        $order->save();
        return redirect()->back()->with('success', 'Order marked as processed and stock updated.');
    }

    public function userOrders()
    {
        $orders = \App\Models\Order::with(['orderItems.product'])
            ->where('user_id', \Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('orders.user_orders', compact('orders'));
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        // Only allow user to cancel their own order if not processed
        if ($order->user_id !== Auth::id() || $order->status !== 'confirmed') {
            abort(403, 'Unauthorized or order already processed/cancelled');
        }
        $order->status = 'cancelled';
        $order->save();
        return redirect()->route('orders.confirmation', $order->id)->with('success', 'Order cancelled successfully.');
    }
}
