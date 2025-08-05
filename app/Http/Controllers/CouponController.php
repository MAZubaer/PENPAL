<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('coupons.index', compact('coupons'));
    }
    public function create()
    {
        return view('coupons.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:percent,amount',
            'value' => 'required|numeric|min:0.01',
            'expires_at' => 'nullable|date',
        ]);
        Coupon::create($request->only('code', 'type', 'value', 'expires_at'));
        return redirect()->route('coupons.index')->with('success', 'Coupon created.');
    }
    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted.');
    }
    public function history()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('coupons.history', compact('coupons'));
    }
}
