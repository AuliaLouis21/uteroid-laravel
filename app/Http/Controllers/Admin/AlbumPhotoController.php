<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumPhoto;
use App\Models\Album;
use App\Http\Requests\Admin\StoreAlbumPhotoRequest;
use App\Http\Requests\Admin\UpdateAlbumPhotoRequest;
use Illuminate\Support\Facades\Storage;

class AlbumPhotoController extends Controller
{
    public function index()
    {
        $photos = AlbumPhoto::with('album')->latest()->paginate(10);

        return view('admin.album-photos.index', compact('photos'));
    }

    public function create()
    {
        $albums = Album::orderBy('name')->get();

        return view('admin.album-photos.create', compact('albums'));
    }

    public function store(StoreAlbumPhotoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('filename')) {
            $data['filename'] = $request->file('filename')->store('albums', 'public');
        }

        AlbumPhoto::create($data);

        return redirect()->route('admin.album-photos.index')
            ->with('success', 'Foto album berhasil ditambahkan.');
    }

    public function show(AlbumPhoto $albumPhoto)
    {
        $albumPhoto->load('album');

        return view('admin.album-photos.show', compact('albumPhoto'));
    }

    public function edit(AlbumPhoto $albumPhoto)
    {
        $albums = Album::orderBy('name')->get();

        return view('admin.album-photos.edit', compact('albumPhoto', 'albums'));
    }

    public function update(UpdateAlbumPhotoRequest $request, AlbumPhoto $albumPhoto)
    {
        $data = $request->validated();

        if ($request->hasFile('filename')) {
            $oldFile = $albumPhoto->filename;
            $data['filename'] = $request->file('filename')->store('albums', 'public');

            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        $albumPhoto->update($data);

        return redirect()->route('admin.album-photos.index')
            ->with('success', 'Foto album berhasil diperbarui.');
    }

    public function destroy(AlbumPhoto $albumPhoto)
    {
        if ($albumPhoto->filename && Storage::disk('public')->exists($albumPhoto->filename)) {
            Storage::disk('public')->delete($albumPhoto->filename);
        }

        $albumPhoto->delete();

        return redirect()->route('admin.album-photos.index')
            ->with('success', 'Foto album berhasil dihapus.');
    }
}
