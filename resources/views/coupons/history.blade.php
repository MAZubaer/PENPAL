@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Coupon History</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Active</th>
                <th>Expires At</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->code }}</td>
                <td>{{ ucfirst($coupon->type) }}</td>
                <td>{{ $coupon->type == 'percent' ? $coupon->value.'%' : '৳'.$coupon->value }}</td>
                <td>{{ $coupon->active ? 'Yes' : 'No' }}</td>
                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '-' }}</td>
                <td>{{ $coupon->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
