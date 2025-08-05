@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Coupons</h1>
    <a href="{{ route('coupons.create') }}" class="btn btn-primary mb-3">Create Coupon</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Active</th>
                <th>Expires At</th>
                <th>Actions</th>
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
                <td>
                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
