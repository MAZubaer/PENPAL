@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h1 class="fun-title mb-4">Wishlist</h1>
    @if($bookmarks->isEmpty())
        <div class="alert alert-info">No products saved for later.</div>
    @else
        <div class="row">
            @foreach($bookmarks as $bookmark)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $bookmark->product->name }}</h5>
                            @if($bookmark->product->image)
                                <img src="{{ asset('storage/'.$bookmark->product->image) }}" alt="Product Image" class="img-fluid mb-2" style="max-height:120px;">
                            @endif
                            <p class="card-text">{{ $bookmark->product->description }}</p>
                            <p class="card-text">Price: ৳{{ $bookmark->product->price }}</p>
                            <form action="{{ route('bookmarks.addToCart', $bookmark->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success">Add to Cart</button>
                            </form>
                            <form action="{{ route('bookmarks.destroy', $bookmark->id) }}" method="POST" class="d-inline ms-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
