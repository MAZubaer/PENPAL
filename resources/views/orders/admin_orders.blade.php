@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h1 class="fun-title mb-4">Confirmed Orders</h1>
    <div class="card p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user ? $order->user->name : 'Unknown User' }}</td>
                    <td>
                        @php $itemList = collect($order->orderItems ?? [])->map(function($item) {
                            $name = $item->product ? $item->product->name : 'Unknown Product';
                            $price = $item->product ? $item->product->price : 0;
                            return $name . ' (৳' . number_format($price,2) . ') - ' . ($item->quantity ?? 1);
                        })->implode(', '); @endphp
                        <span>{{ $itemList }}</span>
                    </td>
                    <td>
                        ৳{{ $order->total }}
                        @if($order->coupon_code)
                            <br><span style="color:#388e3c;font-weight:bold;">Coupon: {{ $order->coupon_code }}</span>
                            <br><span style="color:#d32f2f;font-weight:bold;">Discounted: ৳{{ number_format($order->discounted_total, 2) }}</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        @if($order->status == 'cancelled')
                            <span class="badge bg-warning">Cancelled</span>
                        @else
                            {{ ucfirst($order->status) }}
                        @endif
                    </td>
                    <td>{{ $order->mobile }}<br>{{ $order->address }}</td>
                    <td>
                        <div class="d-flex flex-row align-items-center" style="gap:2px;">
                            @if($order->status == 'confirmed')
                                <form action="{{ route('orders.process', $order->id) }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-cute btn-sm">Mark as Processed</button>
                                </form>
                            @endif
                            @if($order->status == 'cancelled')
                                <span class="badge bg-warning">Order Cancelled</span>
                            @endif
                            @if($order->status == 'processed')
                                <span class="badge bg-success">Processed</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
