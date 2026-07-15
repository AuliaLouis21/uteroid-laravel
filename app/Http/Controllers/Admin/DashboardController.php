<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\News;
use App\Models\Gallery;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'product_categories' => ProductCategory::count(),
            'product_images' => ProductImage::count(),
            'news' => News::count(),
            'galleries' => Gallery::count(),
        ];

        $recentProducts = Product::latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();
        $recentGalleries = Gallery::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentNews', 'recentGalleries'));
    }
}
