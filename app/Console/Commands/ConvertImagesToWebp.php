<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Imagick;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:convert-webp
                            {--disk=public : The storage disk to scan}
                            {--quality=80 : WebP compression quality (1-100)}
                            {--force : Re-convert even if WebP already exists}';

    protected $description = 'Batch convert all images in storage to WebP format';

    public function handle(): int
    {
        $disk = $this->option('disk');
        $quality = (int) $this->option('quality');
        $force = $this->option('force');

        if (!class_exists(Imagick::class)) {
            $this->error('PHP Imagick extension is not installed. Please install it first.');

            return Command::FAILURE;
        }

        $directories = ['', 'images', 'products', 'news', 'galleries', 'albums', 'advertisements'];
        $converted = 0;
        $skipped = 0;
        $failed = 0;

        $this->info("Scanning disk: {$disk}");
        $this->newLine();

        foreach ($directories as $directory) {
            $files = Storage::disk($disk)->files($directory);

            foreach ($files as $file) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    continue;
                }

                $webpPath = preg_replace('/\.(jpe?g|png|gif)$/i', '.webp', $file);

                if (!$force && Storage::disk($disk)->exists($webpPath)) {
                    $skipped++;
                    continue;
                }

                try {
                    $imagePath = Storage::disk($disk)->path($file);
                    $webpFullPath = Storage::disk($disk)->path($webpPath);

                    $imagick = new Imagick($imagePath);
                    $imagick->setImageFormat('webp');
                    $imagick->setImageCompressionQuality($quality);
                    $imagick->writeImage($webpFullPath);
                    $imagick->destroy();

                    $converted++;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error("  Failed: {$file} — {$e->getMessage()}");
                    $failed++;
                }
            }
        }

        $this->newLine();
        $this->info("✅ Conversion complete!");
        $this->info("   Converted: {$converted}");
        $this->info("   Skipped:   {$skipped}");
        $this->info("   Failed:    {$failed}");

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
