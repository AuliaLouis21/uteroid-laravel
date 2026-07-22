<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\News;
use App\Models\Album;
use App\Models\Order;
use App\Models\Page;
use App\Models\Advertisement;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'product_categories' => ProductCategory::count(),
            'product_images' => ProductImage::count(),
            'news' => News::count(),
            'albums' => Album::count(),
            'orders' => Order::count(),
            'pages' => Page::count(),
            'advertisements' => Advertisement::count(),
        ];

        $recentProducts = Product::latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();
        $recentAlbums = Album::latest()->take(5)->get();
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentNews', 'recentAlbums', 'recentOrders'));
    }
}
