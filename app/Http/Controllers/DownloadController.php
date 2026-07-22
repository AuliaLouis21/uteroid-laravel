<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->get();

        return view('download.index', compact('downloads'));
    }

    public function download(Download $download)
    {
        if ($download->isGdrive()) {
            return redirect($download->gdrive_url);
        }

        $disk = Storage::disk('public');

        if (!$download->file_path || !$disk->exists($download->file_path)) {
            abort(404);
        }

        $filename = basename($download->file_path);

        return $disk->download($download->file_path, $filename);
    }
}
