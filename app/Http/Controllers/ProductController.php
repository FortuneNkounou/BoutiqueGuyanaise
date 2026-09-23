<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('active', true)->with('categories');
        $categories = Category::all();

        if ($request->filled('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('description', 'like', "%$s%"));
        }

        $products = $query->orderBy('name')->paginate(12);

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (!$product->active) abort(404);

        $product->load('categories');

        $related = Product::where('active', true)
            ->where('id', '!=', $product->id)
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $product->categories->pluck('id')))
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
