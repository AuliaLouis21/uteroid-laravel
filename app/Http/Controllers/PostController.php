<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('src')) {
            $query->where('title', 'like', '%' . $request->src . '%');
        }

        $posts = $query->latest()->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Cache::remember("post.{$slug}", 1800, fn() =>
            News::where('slug', $slug)->first()
        );

        if (!$post) {
            abort(404);
        }

        $relatedPosts = Cache::remember("post.{$slug}.related", 1800, fn() =>
            News::where('id', '!=', $post->id)
                ->latest()
                ->take(3)
                ->get()
        );

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
