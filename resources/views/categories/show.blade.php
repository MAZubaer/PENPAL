@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>
    <h4>Products in this Category:</h4>
    <ul class="list-group mb-3">
        @foreach($category->products as $product)
            <li class="list-group-item">
                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
