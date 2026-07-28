<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AlbumResource;
use App\Models\Album;
use App\Models\AlbumVideo;
use App\Models\AlbumAudio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GalleryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->get('per_page', 12), 50));
        $albums = Album::with(['photos:id,album_id,filename,caption', 'category'])
            ->withCount('photos')
            ->latest()
            ->paginate($perPage);

        return AlbumResource::collection($albums);
    }

    public function photos(string $slug): AlbumResource|JsonResponse
    {
        $album = Album::with('photos', 'category')
            ->where('slug', $slug)
            ->first();

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        return new AlbumResource($album);
    }

    public function videos(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->get('per_page', 12), 50));
        $videos = AlbumVideo::latest()
            ->paginate($perPage);

        return \App\Http\Resources\V1\AlbumVideoResource::collection($videos);
    }

    public function audios(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->get('per_page', 12), 50));
        $audios = AlbumAudio::latest()
            ->paginate($perPage);

        return \App\Http\Resources\V1\AlbumAudioResource::collection($audios);
    }
}
