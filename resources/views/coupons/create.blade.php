@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Create Coupon</h1>
    <form action="{{ route('coupons.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="percent">Percent (%)</option>
                <option value="amount">Flat Amount (৳)</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="value" class="form-label">Value</label>
            <input type="number" name="value" id="value" class="form-control" step="0.01" min="0.01" required>
        </div>
        <div class="mb-3">
            <label for="expires_at" class="form-label">Expires At</label>
            <input type="date" name="expires_at" id="expires_at" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
