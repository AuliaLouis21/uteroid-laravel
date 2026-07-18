<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumVideo;
use App\Models\AlbumAudio;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::withCount('photos')->get();
        $videos = AlbumVideo::latest()->take(6)->get();
        $audios = AlbumAudio::latest()->take(6)->get();
        $noSidebar = true;

        return view('gallery.index', compact('albums', 'videos', 'audios', 'noSidebar'));
    }

    public function photos(string $slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->firstOrFail();
        $noSidebar = true;

        return view('gallery.photos', compact('album', 'noSidebar'));
    }

    public function videos(string $slug = null)
    {
        $album = null;
        $videos = collect();
        $noSidebar = true;

        if ($slug) {
            $album = Album::with('videos')->where('slug', $slug)->firstOrFail();
            $videos = $album->videos;
        } else {
            $videos = AlbumVideo::latest()->paginate(12);
        }

        return view('gallery.videos', compact('album', 'videos', 'noSidebar'));
    }
}
