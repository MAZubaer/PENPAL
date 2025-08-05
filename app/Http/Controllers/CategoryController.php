<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('categories.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        Category::create($data);
        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        $category->update($data);
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $category->delete();
        return redirect()->route('categories.index');
    }
}
