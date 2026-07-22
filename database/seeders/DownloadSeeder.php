<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadSeeder extends Seeder
{
    public function run(): void
    {
        $disk = Storage::disk('public');
        $directory = 'downloads';

        if (!$disk->exists($directory)) {
            return;
        }

        $files = $disk->allFiles($directory);

        foreach ($files as $path) {
            $fileName = basename($path);
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            Download::create([
                'name' => pathinfo($fileName, PATHINFO_FILENAME),
                'type' => 'file',
                'file_path' => $path,
                'extension' => $extension,
                'size' => $disk->size($path),
            ]);
        }
    }
}
