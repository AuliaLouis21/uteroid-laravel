<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = News::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $perPage = max(1, min((int) $request->get('per_page', 9), 50));
        $posts = $query->latest()->paginate($perPage);

        return NewsResource::collection($posts);
    }

    public function show(string $slug): NewsResource|JsonResponse
    {
        $post = News::where('slug', $slug)->first();

        if (!$post) {
            return response()->json(['message' => 'News not found'], 404);
        }

        return new NewsResource($post);
    }
}
