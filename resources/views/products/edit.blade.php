@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" class="img-fluid mt-2" style="max-height:120px;">
            @endif
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required step="0.01">
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
