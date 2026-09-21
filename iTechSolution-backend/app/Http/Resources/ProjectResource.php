<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'image' => $this->image ? Storage::disk('public')->url($this->image) : null,
        ];
    }
}
