<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category');

        if ($request->filled('src')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->src . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->src . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(9)->withQueryString();

        $recentPosts = Cache::remember('news.recent_posts', 1800, fn() =>
            News::latest()->take(5)->get()
        );

        $categories = Cache::remember('news.categories_with_count', 3600, fn() =>
            Category::withCount('posts')->having('posts_count', '>', 0)->orderBy('name')->get()
        );

        $tags = $this->getPopularTags();

        return view('news.index', compact('posts', 'recentPosts', 'categories', 'tags'));
    }

    public function show(string $slug)
    {
        $post = Cache::remember("post.{$slug}", 1800, fn() =>
            News::with('category')->where('slug', $slug)->first()
        );

        if (!$post) {
            abort(404);
        }

        $relatedPosts = Cache::remember("post.{$slug}.related", 1800, fn() =>
            News::with('category')
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(3)
                ->get()
        );

        $recentPosts = Cache::remember('news.recent_posts', 1800, fn() =>
            News::latest()->take(5)->get()
        );

        $categories = Cache::remember('news.categories_with_count', 3600, fn() =>
            Category::withCount('posts')->having('posts_count', '>', 0)->orderBy('name')->get()
        );

        $tags = $this->getPopularTags();

        return view('news.show', compact('post', 'relatedPosts', 'recentPosts', 'categories', 'tags'));
    }

    private function getPopularTags(): array
    {
        return Cache::remember('news.popular_tags', 3600, function () {
            $tags = News::whereNotNull('excerpt')
                ->pluck('excerpt')
                ->flatMap(function ($excerpt) {
                    preg_match_all('/#(\w+)/', $excerpt, $matches);
                    return $matches[1] ?? [];
                })
                ->countBy()
                ->sortDesc()
                ->take(15)
                ->keys()
                ->toArray();

            if (empty($tags)) {
                return [
                    'Advertising', 'Printing', 'Malang', 'Digital',
                    'Creative', 'Branding', 'Promo', 'Design',
                ];
            }

            return $tags;
        });
    }
}
