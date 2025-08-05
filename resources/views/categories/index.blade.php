@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Categories</h1>
    @if(auth()->user() && auth()->user()->role === 'admin')
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
    @endif
    <ul class="list-group">
        @foreach($categories as $category)
            <li class="list-group-item">
                {{ $category->name }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
