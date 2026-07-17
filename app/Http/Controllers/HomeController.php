<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\News;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $promoProducts = Product::where('is_promo', true)
            ->latest()
            ->take(6)
            ->get();

        $latestNews = News::latest()
            ->take(3)
            ->get();

        $latestGalleries = Gallery::latest()
            ->take(6)
            ->get();

        return view('home.index', compact('promoProducts', 'latestNews', 'latestGalleries'));
    }
}
