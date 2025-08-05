@extends('layouts.app')
@section('content')
<div class="container text-center mt-5">
    <h1 class="fun-title mb-3">Confirm Your Order</h1>
    <p class="fun-desc mb-4">Please enter your mobile number and address to complete your order.</p>
    <form action="{{ route('order.store') }}" method="POST" class="mx-auto" style="max-width:400px;">
        @csrf
        <div class="mb-3">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
        </div>
        <div class="mb-3">
            <textarea name="address" class="form-control" placeholder="Address" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <input type="text" name="coupon_code" class="form-control" placeholder="Coupon Code (optional)">
        </div>
        <button type="submit" class="btn btn-cute w-100">Confirm Order</button>
    </form>
</div>
@endsection
