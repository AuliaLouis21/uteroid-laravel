<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(15);

        return view('admin.downloads.index', compact('downloads'));
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $disk = Storage::disk('public');
        $path = 'downloads/' . $filename;

        if ($disk->exists($path)) {
            $filename = pathinfo($filename, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
            $path = 'downloads/' . $filename;
        }

        $file->storeAs('downloads', $filename, 'public');

        Download::create([
            'name' => pathinfo($filename, PATHINFO_FILENAME),
            'type' => 'file',
            'file_path' => $path,
            'extension' => $extension,
            'size' => $file->getSize(),
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File "' . $filename . '" uploaded successfully.');
    }

    public function storeGdrive(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gdrive_url' => 'required|url|max:500',
        ]);

        Download::create([
            'name' => $request->name,
            'type' => 'gdrive',
            'gdrive_url' => $request->gdrive_url,
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Link Google Drive added successfully.');
    }

    public function destroy(Download $download)
    {
        if ($download->isFile() && $download->file_path) {
            $disk = Storage::disk('public');
            if ($disk->exists($download->file_path)) {
                $disk->delete($download->file_path);
            }
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download deleted successfully.');
    }
}
