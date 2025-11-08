<?php

namespace App\Http\Controllers\Front;

use App\Models\{Product, Category};
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::latest()->get();
        return view('shop', compact('categories', 'products'));
    }

    public function getCategoryProducts($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $products = $category->products;

        return view('product-list', compact('products'));
    }
}
