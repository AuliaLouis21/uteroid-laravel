<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\ProductCategory;
use App\Models\News;
use App\Models\Advertisement;
use App\Models\Page;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $categories = ProductCategory::withCount('products')->orderBy('name')->get();
        $latestNews = News::latest()->take(5)->get();
        $advertisements = Advertisement::where('is_active', true)->latest()->take(10)->get();
        $staticPages = Page::orderBy('id')->get();

        View::share(compact('categories', 'latestNews', 'advertisements', 'staticPages'));
    }
}
