<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

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
        $post = News::where('slug', $slug)->firstOrFail();

        $relatedPosts = News::where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
