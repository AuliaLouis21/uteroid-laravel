<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumAudio;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumAudioController extends Controller
{
    public function index()
    {
        $audios = AlbumAudio::with('album')->latest()->paginate(10);

        return view('admin.album-audios.index', compact('audios'));
    }

    public function create()
    {
        $albums = Album::orderBy('name')->get();

        return view('admin.album-audios.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id' => ['nullable', 'exists:albums,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:album_audio,slug'],
            'filename' => ['required', 'file', 'mimes:mp3,wav,ogg,aac,m4a', 'max:10240'],
            'description' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('filename')) {
            $data['filename'] = $request->file('filename')->store('audio', 'public');
        }

        AlbumAudio::create($data);

        return redirect()->route('admin.audio.index')
            ->with('success', 'Audio berhasil ditambahkan.');
    }

    public function show(AlbumAudio $audio)
    {
        $audio->load('album');

        return view('admin.album-audios.show', compact('audio'));
    }

    public function edit(AlbumAudio $audio)
    {
        $albums = Album::orderBy('name')->get();

        return view('admin.album-audios.edit', compact('audio', 'albums'));
    }

    public function update(Request $request, AlbumAudio $audio)
    {
        $data = $request->validate([
            'album_id' => ['nullable', 'exists:albums,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:album_audio,slug,' . $audio->id],
            'filename' => ['nullable', 'file', 'mimes:mp3,wav,ogg,aac,m4a', 'max:10240'],
            'description' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('filename')) {
            if ($audio->filename && Storage::disk('public')->exists($audio->filename)) {
                Storage::disk('public')->delete($audio->filename);
            }

            $data['filename'] = $request->file('filename')->store('audio', 'public');
        }

        $audio->update($data);

        return redirect()->route('admin.audio.index')
            ->with('success', 'Audio berhasil diperbarui.');
    }

    public function destroy(AlbumAudio $audio)
    {
        if ($audio->filename && Storage::disk('public')->exists($audio->filename)) {
            Storage::disk('public')->delete($audio->filename);
        }

        $audio->delete();

        return redirect()->route('admin.audio.index')
            ->with('success', 'Audio berhasil dihapus.');
    }
}
