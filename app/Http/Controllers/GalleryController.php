<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumVideo;
use App\Models\AlbumAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Cache::remember('gallery.albums', 1800, fn() =>
            Album::with('photos:id,album_id,filename')->get()
        );
        $videos = Cache::remember('gallery.videos', 1800, fn() =>
            AlbumVideo::latest()->take(6)->get()
        );
        $audios = Cache::remember('gallery.audios', 1800, fn() =>
            AlbumAudio::latest()->take(6)->get()
        );
        $noSidebar = true;

        return view('gallery.index', compact('albums', 'videos', 'audios', 'noSidebar'));
    }

    public function photos(string $slug)
    {
        $album = Cache::remember("gallery.album.{$slug}", 1800, fn() =>
            Album::with('photos')->where('slug', $slug)->first()
        );

        if (!$album) {
            abort(404);
        }

        $noSidebar = true;

        return view('gallery.photos', compact('album', 'noSidebar'));
    }

    public function videos(string $slug = null)
    {
        $album = null;
        $videos = collect();
        $noSidebar = true;

        if ($slug) {
            $album = Cache::remember("gallery.videos.{$slug}", 1800, fn() =>
                Album::with('videos')->where('slug', $slug)->first()
            );

            if (!$album) {
                abort(404);
            }

            $videos = $album->videos;
        } else {
            $videos = AlbumVideo::latest()->paginate(12);
        }

        return view('gallery.videos', compact('album', 'videos', 'noSidebar'));
    }
}
