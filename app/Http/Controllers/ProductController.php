<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->filled('src')) {
            $query->where('name', 'like', '%' . $request->src . '%');
        }

        if ($request->filled('cat')) {
            $category = ProductCategory::where('slug', $request->cat)->first();
            if ($category) {
                $query->where('product_category_id', $category->id);
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'images', 'type'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::with('images')
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category(Request $request, string $slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();

        $query = Product::with(['category', 'images'])
            ->where('product_category_id', $category->id);

        if ($request->filled('src')) {
            $query->where('name', 'like', '%' . $request->src . '%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('products.category', compact('category', 'products'));
    }
}
