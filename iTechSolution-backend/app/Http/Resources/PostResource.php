<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'coverImage' => $this->cover_image ? Storage::disk('public')->url($this->cover_image) : null,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->tags),
            'author' => new AuthorResource($this->author),
            'publishedAt' => $this->published_at?->toIso8601String(),
            'minutesToRead' => $this->minutes_to_read,
        ];
    }
}
