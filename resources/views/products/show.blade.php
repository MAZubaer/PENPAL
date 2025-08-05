@extends('layouts.app')
@section('content')
<div class="container-fluid py-5" style="max-width:1700px;">
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-10 col-md-12 col-12" style="max-width:1400px;">
      <div class="card shadow-lg p-4" style="border-radius:32px;">
        <div class="row g-0 align-items-center">
          <div class="col-md-6 text-center">
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" class="img-fluid mb-3" style="max-height:320px; border-radius:24px; box-shadow:0 4px 24px #b2d7e6;">
            @else
              <div class="bg-light d-flex align-items-center justify-content-center" style="height:320px; border-radius:24px;">
                <span class="text-muted">No Image</span>
              </div>
            @endif
          </div>
          <div class="col-md-6">
            <h1 class="fun-title mb-2" style="font-size:2.5rem;">{{ $product->name }}</h1>
            <p class="mb-3" style="font-size:1.2rem; color:#555;">{{ $product->description }}</p>
            <h3 class="mb-2" style="color:#388e3c; font-weight:bold;">৳{{ $product->price }}</h3>
            <ul class="list-unstyled mb-3">
              <li><span style="font-size:1.2rem;">🗂️ Category:</span> <span style="color:#3b5998;">{{ $product->category ? $product->category->name : 'None' }}</span></li>
              <li><span style="font-size:1.2rem;">📦 Stock:</span> <span style="color:#ff9800;">{{ $product->stock }}</span></li>
            </ul>
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-3">
              @csrf
              <button class="btn btn-success btn-lg w-100" style="font-size:1.2rem;">Add to Cart</button>
            </form>
            <form action="{{ route('bookmarks.store', $product->id) }}" method="POST" class="mb-3">
              @csrf
              <button class="btn btn-warning btn-lg w-100" style="font-size:1.2rem;">Add to Wishlist</button>
            </form>
            @if(auth()->user() && auth()->user()->role === 'admin')
              <a href="{{ route('products.edit', $product) }}" class="btn btn-warning w-100 mb-2">Edit</a>
              <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block; width:100%;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger w-100">Delete</button>
              </form>
            @endif
            <a href="{{ route('products.index') }}" class="btn btn-secondary w-100 mt-2">Back to Products</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center mt-4">
    <div class="col-lg-10 col-md-12 col-12" style="max-width:1400px;">
      <div class="card p-4 mb-4">
        @php
          $avg = $product->reviews()->avg('rating');
          $count = $product->reviews()->count();
        @endphp
        <h4>Average Rating: {{ $avg ? number_format($avg,1) : 'N/A' }} ({{ $count }} reviews)</h4>
        @auth
        <form action="{{ route('products.review', $product->id) }}" method="POST" class="mb-3">
          @csrf
          <div class="mb-2">
            <label for="rating">Your Rating:</label>
            <select name="rating" id="rating" class="form-select d-inline w-auto">
              @for($i=1;$i<=5;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>
          </div>
          <div class="mb-2">
            <textarea name="comment" class="form-control" placeholder="Your review (optional)"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
        @endauth
        <h5>Customer Reviews:</h5>
        @forelse($product->reviews as $review)
          <div class="border rounded p-2 mb-2">
            <strong>{{ $review->user->name }}</strong> - <span>{{ $review->rating }}★</span><br>
            <span class="text-muted">{{ $review->created_at->format('Y-m-d') }}</span>
            <p>{{ $review->comment }}</p>
          </div>
        @empty
          <div class="text-muted">No reviews yet.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
