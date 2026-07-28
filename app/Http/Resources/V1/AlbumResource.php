<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'photos' => AlbumPhotoResource::collection($this->whenLoaded('photos')),
            'videos' => AlbumVideoResource::collection($this->whenLoaded('videos')),
            'audios' => AlbumAudioResource::collection($this->whenLoaded('audios')),
            'photos_count' => $this->whenCounted('photos'),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
