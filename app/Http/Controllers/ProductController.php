<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // Sorting logic
        $sort = request('sort');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'date_asc') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'date_desc') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $categories = \App\Models\Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        Product::create($data);
        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $categories = \App\Models\Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);
        return redirect()->route('products.index');
    }
    public function byCategory(\App\Models\Category $category)
    {
        $products = $category->products;
        // Always pass category ID for route helpers
        $categoryId = $category->id;
        return view('products.index', compact('products', 'category', 'categoryId'));
    }

    public function destroy(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $product->delete();
        return redirect()->route('products.index');
    }
}
