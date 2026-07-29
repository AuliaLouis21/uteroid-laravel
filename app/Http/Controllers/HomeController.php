<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\News;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class HomeController extends Controller
{
    public function index()
    {
        $promoProducts = Cache::remember('home.promo_products', 600, fn() =>
            Product::with(['category', 'images'])
                ->where('is_promo', true)
                ->latest()
                ->get()
        );
        
        $promoProductsJson = new HtmlString($promoProducts->toJson());

        $latestProducts = Cache::remember('home.latest_products', 600, fn() =>
            Product::with(['category', 'images'])
                ->latest()
                ->take(12)
                ->get()
        );

        $categories = Cache::remember('home.categories', 3600, fn() =>
            ProductCategory::withCount('products')->orderBy('name')->get()
        );

        $latestNews = Cache::remember('home.latest_news', 600, fn() =>
            News::latest()->take(5)->get()
        );

        $advertisements = Cache::remember('home.advertisements', 600, fn() =>
            Advertisement::where('is_active', true)->latest()->take(10)->get()
        );

        return view('home.index', compact('promoProducts', 'promoProductsJson', 'latestProducts', 'categories', 'latestNews', 'advertisements'));
    }
}
