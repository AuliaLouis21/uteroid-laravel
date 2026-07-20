<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumVideo;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumVideoController extends Controller
{
    public function index()
    {
        $videos = AlbumVideo::with('album')->latest()->paginate(10);

        return view('admin.album-videos.index', compact('videos'));
    }

    public function create()
    {
        $albums = Album::orderBy('name')->get();

        return view('admin.album-videos.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id' => ['nullable', 'exists:albums,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:album_videos,slug'],
            'url' => ['required', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
        ]);

        AlbumVideo::create($data);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function show(AlbumVideo $video)
    {
        $video->load('album');

        return view('admin.album-videos.show', compact('video'));
    }

    public function edit(AlbumVideo $video)
    {
        $albums = Album::orderBy('name')->get();

        return view('admin.album-videos.edit', compact('video', 'albums'));
    }

    public function update(Request $request, AlbumVideo $video)
    {
        $data = $request->validate([
            'album_id' => ['nullable', 'exists:albums,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:album_videos,slug,' . $video->id],
            'url' => ['required', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
        ]);

        $video->update($data);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(AlbumVideo $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video berhasil dihapus.');
    }
}
