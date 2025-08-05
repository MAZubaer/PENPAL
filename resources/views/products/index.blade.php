@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-12 text-end">
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
                <a href="{{ route('orders.admin') }}" class="btn btn-warning mb-3 ms-2">View Orders</a>
                <a href="{{ route('coupons.create') }}" class="btn btn-info mb-3 ms-2">Create Coupon</a>
            @endif
        </div>
    </div>
    @isset($category)
        <h1>{{ $category->name }}</h1>
        @if($category->description)
            <p>{{ $category->description }}</p>
        @endif
        <h4>Products in this Category</h4>
        <!-- Example usage: always use $categoryId for route helpers -->
        <!-- <a href="{{ route('categories.products', $categoryId) }}">View All</a> -->
    @else
        <h1>Stationary Products</h1>
    @endisset
    <form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label for="sort" class="form-label">Sort By</label>
            <select name="sort" id="sort" class="form-select">
                <option value="">Default</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High (৳)</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low (৳)</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-select">
                <option value="">All Categories</option>
                @foreach(App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="search" class="form-label">Search</label>
            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Product name or keyword">
        </div>
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-cute">Filter</button>
        </div>
    </form>
    {{-- Removed duplicate admin buttons --}}
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4 h-100" style="min-height: 420px; display: flex; flex-direction: column; justify-content: stretch;">
                    <div class="card-body d-flex flex-column" style="height: 100%;">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" class="img-fluid mb-2" style="height:180px;width:180px;object-fit:cover;border-radius:12px;background:#fff;box-shadow:0 2px 8px #b2d7e644;">
                        @endif
                        <p class="card-text text-truncate" style="max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $product->description }}</p>
                        <p class="card-text">Price: ৳{{ $product->price }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>
                        <p class="card-text">Category: {{ $product->category ? $product->category->name : 'None' }}</p>
                        @php
                            $avg = $product->reviews()->avg('rating');
                            $count = $product->reviews()->count();
                        @endphp
                        <p class="card-text">Average Rating: {{ $avg ? number_format($avg,1) : 'N/A' }} ({{ $count }} reviews)</p>
                        <div class="d-flex flex-column align-items-center justify-content-center" style="gap:6px;">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info w-100" style="width:140px;height:44px;font-size:1.1rem;">View</a>
                            <div class="d-flex flex-row align-items-center justify-content-center" style="gap:6px;">
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-0">
                                    @csrf
                                    <button class="btn btn-success w-100" style="width:140px;height:44px;font-size:1.1rem;">Add to Cart</button>
                                </form>
                                <form action="{{ route('bookmarks.store', $product->id) }}" method="POST" class="mb-0">
                                    @csrf
                                    <button class="btn btn-warning w-100" style="width:140px;height:44px;font-size:1.1rem;">Add to Wishlist</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
