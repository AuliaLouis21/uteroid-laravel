<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('category')->withCount('photos')->latest()->paginate(10);

        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.albums.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:albums,slug'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        Album::create($data);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album berhasil ditambahkan.');
    }

    public function show(Album $album)
    {
        $album->load('photos', 'category');

        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $categories = Category::orderBy('name')->get();
        $album->load('photos');

        return view('admin.albums.edit', compact('album', 'categories'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:albums,slug,' . $album->id],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $album->update($data);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $album)
    {
        foreach ($album->photos as $photo) {
            if ($photo->filename && Storage::disk('public')->exists($photo->filename)) {
                Storage::disk('public')->delete($photo->filename);
            }
            $photo->delete();
        }

        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album berhasil dihapus.');
    }

    public function addPhoto(Request $request, Album $album)
    {
        $request->validate([
            'filename' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $data = ['album_id' => $album->id];

        if ($request->hasFile('filename')) {
            $data['filename'] = $request->file('filename')->store('albums', 'public');
        }

        $data['caption'] = $request->caption;

        AlbumPhoto::create($data);

        return redirect()->route('admin.albums.edit', $album)
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    public function deletePhoto(Album $album, AlbumPhoto $photo)
    {
        if ($photo->filename && Storage::disk('public')->exists($photo->filename)) {
            Storage::disk('public')->delete($photo->filename);
        }

        $photo->delete();

        return redirect()->route('admin.albums.edit', $album)
            ->with('success', 'Foto berhasil dihapus.');
    }
}
