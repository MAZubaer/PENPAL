@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Order Placed!</h1>
    <p>Your order has been placed successfully.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection
