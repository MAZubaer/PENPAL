@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Your Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cartItems as $item)
                @if($item->product)
                    @php $total += $item->product->price * $item->quantity; @endphp
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            <input type="number" name="quantities[{{ $item->product->id }}]" value="{{ $item->quantity }}" min="1" class="form-control" style="width:70px; margin-right:8px;" form="update-cart-form">
                        </td>
                        <td class="cart-price" data-unit-price="{{ $item->product->price }}">৳{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-danger">This product is no longer available.</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <form id="update-cart-form" action="{{ route('cart.update.all') }}" method="POST">
        @csrf
        <div class="text-end mb-3">
            <h4>Total: <span id="cart-total" style="color:#388e3c">৳{{ number_format($total, 2) }}</span></h4>
            <button type="submit" class="btn btn-primary" id="update-cart-btn">Update Cart</button>
        </div>
    </form>
    <form action="{{ route('order.input') }}" method="GET">
        <button class="btn btn-success">Confirm Order</button>
    </form>
</div>
@section('scripts')
<script>
// No custom JS needed for single form submit
</script>
@endsection
</div>
@endsection
