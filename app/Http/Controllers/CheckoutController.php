<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);
        $coupon = Coupon::where('code', $request->code)
            ->where('active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();
        if (!$coupon) {
            return back()->withErrors(['code' => 'Invalid or expired coupon code.']);
        }
        Session::put('applied_coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);
        return back()->with('success', 'Coupon applied!');
    }
}
