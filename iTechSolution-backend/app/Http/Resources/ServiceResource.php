<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'icon' => $this->icon,
            'image' => $this->image ? Storage::disk('public')->url($this->image) : null,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
