<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\News;
use App\Models\Advertisement;
use Illuminate\Support\HtmlString;

class HomeController extends Controller
{
    public function index()
    {
        $promoProducts = Product::with(['category', 'images'])
            ->where('is_promo', true)
            ->latest()
            ->get();
        $promoProductsJson = new HtmlString($promoProducts->toJson());

        $latestProducts = Product::with(['category', 'images'])
            ->latest()
            ->take(12)
            ->get();

        $categories = ProductCategory::withCount('products')->orderBy('name')->get();

        $latestNews = News::latest()->take(5)->get();

        $advertisements = Advertisement::where('is_active', true)->latest()->take(10)->get();

        return view('home.index', compact('promoProducts', 'promoProductsJson', 'latestProducts', 'categories', 'latestNews', 'advertisements'));
    }
}
