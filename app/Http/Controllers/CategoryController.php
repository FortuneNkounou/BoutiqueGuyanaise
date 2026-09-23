<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()->where('active', true)->paginate(12);
        return view('categories.show', compact('category', 'products'));
    }
}
