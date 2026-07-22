<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'file_path',
        'gdrive_url',
        'extension',
        'size',
    ];

    public function isFile(): bool
    {
        return $this->type === 'file';
    }

    public function isGdrive(): bool
    {
        return $this->type === 'gdrive';
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    public function getFileIconAttribute(): string
    {
        return match ($this->extension) {
            'pdf' => 'fa-file-pdf-o',
            'doc', 'docx' => 'fa-file-word-o',
            'xls', 'xlsx' => 'fa-file-excel-o',
            'ppt', 'pptx' => 'fa-file-powerpoint-o',
            'zip', 'rar', '7z' => 'fa-file-archive-o',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'fa-file-image-o',
            'mp3', 'wav', 'ogg' => 'fa-file-audio-o',
            'mp4', 'avi', 'mkv' => 'fa-file-video-o',
            'txt' => 'fa-file-text-o',
            default => 'fa-file-o',
        };
    }
}
