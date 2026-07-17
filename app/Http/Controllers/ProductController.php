<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        $categories = ProductCategory::withCount('products')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'images', 'type'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category(string $slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        $products = Product::where('product_category_id', $category->id)
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::withCount('products')->get();

        return view('products.category', compact('category', 'products', 'categories'));
    }
}
