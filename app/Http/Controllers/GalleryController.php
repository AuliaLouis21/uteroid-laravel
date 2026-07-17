<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Album;
use App\Models\Video;
use App\Models\Audio;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        $albums = Album::withCount(['photos', 'videos', 'audios'])->get();
        $videos = Video::latest()->take(6)->get();
        $audios = Audio::latest()->take(6)->get();

        return view('gallery.index', compact('galleries', 'albums', 'videos', 'audios'));
    }

    public function photos(string $slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->firstOrFail();

        return view('gallery.photos', compact('album'));
    }

    public function videos(string $slug = null)
    {
        $album = null;
        $videos = collect();

        if ($slug) {
            $album = Album::with('videos')->where('slug', $slug)->firstOrFail();
        } else {
            $videos = Video::latest()->paginate(12);
        }

        return view('gallery.videos', compact('album', 'videos'));
    }
}
