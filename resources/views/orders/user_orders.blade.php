@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h1 class="fun-title mb-4">My Orders</h1>
    <div class="card p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        @php $itemList = collect($order->orderItems ?? [])->map(function($item) {
                            $name = $item->product ? $item->product->name : 'Unknown Product';
                            $price = $item->product ? $item->product->price : 0;
                            return $name . ' (৳' . number_format($price,2) . ') - ' . ($item->quantity ?? 1);
                        })->implode(', '); @endphp
                        <span>{{ $itemList }}</span>
                    </td>
                    <td>
                        @if($order->coupon_code)
                            <span style="color:#388e3c;font-weight:bold;">৳{{ number_format($order->discounted_total, 2) }}</span>
                            <br><span style="color:#d32f2f;font-weight:bold;">(Coupon: {{ $order->coupon_code }})</span>
                        @else
                            ৳{{ $order->total }}
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        @if($order->status == 'cancelled')
                            <span class="badge bg-warning">Cancelled</span>
                        @elseif($order->status == 'processed')
                            <span class="badge bg-success">Processed</span>
                        @else
                            <span class="badge bg-info">Confirmed</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
