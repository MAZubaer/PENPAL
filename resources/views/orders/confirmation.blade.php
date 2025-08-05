@extends('layouts.app')
@section('content')
<div class="container text-center mt-5">
    @if($order->status == 'cancelled')
        <h1 class="fun-title mb-3 text-warning">Order Cancelled</h1>
        <p class="fun-desc mb-4">Your order has been cancelled. If this was a mistake, please contact support.</p>
    @else
        <h1 class="fun-title mb-3">Order Confirmed!</h1>
        <p class="fun-desc mb-4">Thank you for shopping with PENPAL. Your order has been placed and is being processed.</p>
    @endif
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn btn-cute m-2" style="min-width:120px;">Continue Shopping</a>
        <a href="{{ route('home') }}" class="btn btn-cute m-2" style="min-width:120px;">Go to Dashboard</a>
    </div>
    <hr class="my-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h4 class="mb-3" style="color:#388e3c; font-family:'Baloo 2','Comic Sans MS',cursive;">Order Details</h4>
            <ul class="feature-list list-unstyled">
                <li>📝 Order ID: {{ $order->id }}</li>
                <li>💰 Original Total: ৳{{ number_format($order->total, 2) }}</li>
                @if($order->coupon_code)
                    <li>🏷️ Coupon Used: {{ $order->coupon_code }}</li>
                    <li>💸 Price After Coupon: ৳{{ number_format($order->discounted_total, 2) }}</li>
                @endif
                <li>📅 Date: {{ $order->created_at->format('d M Y, h:i A') }}</li>
                <li>📱 Mobile: {{ $order->mobile }}</li>
                <li>🏠 Address: {{ $order->address }}</li>
            </ul>
            <div class="mt-4 text-start">
                <h5>Ordered Products:</h5>
                @php $itemList = collect($order->orderItems ?? [])->map(function($item) {
                    $name = $item->product ? $item->product->name : 'Unknown Product';
                    $price = $item->product ? $item->product->price : 0;
                    return $name . ' (৳' . number_format($price,2) . ') - ' . ($item->quantity ?? 1);
                })->implode(', '); @endphp
                <span>{{ $itemList }}</span>
            </div>
            </ul>
            @if($order->status == 'confirmed')
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                </form>
            @elseif($order->status == 'cancelled')
                <div class="alert alert-warning mt-3">Order Cancelled</div>
            @endif
        </div>
    </div>
</div>
@endsection
