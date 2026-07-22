<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\ProductCategory;
use App\Models\News;
use App\Models\Advertisement;
use App\Models\Page;
use App\Services\WhatsAppService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once app_path('Helpers/helpers.php');

        $this->app->singleton(WhatsAppService::class, function () {
            return new WhatsAppService();
        });
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $viewName = $view->getName();
            if (str_starts_with($viewName, 'admin.')) {
                return;
            }

            try {
                $view->with([
                    'categories' => ProductCategory::withCount('products')->orderBy('name')->get(),
                    'latestNews' => News::latest()->take(5)->get(),
                    'advertisements' => Advertisement::where('is_active', true)->latest()->take(10)->get(),
                    'staticPages' => Page::orderBy('id')->get(),
                ]);
            } catch (\Exception $e) {
                $view->with([
                    'categories' => collect(),
                    'latestNews' => collect(),
                    'advertisements' => collect(),
                    'staticPages' => collect(),
                ]);
            }
        });
    }
}
