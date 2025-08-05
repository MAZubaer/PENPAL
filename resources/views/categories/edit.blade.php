@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
