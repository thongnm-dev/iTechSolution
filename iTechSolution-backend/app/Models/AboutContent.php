<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'hero_title', 'hero_subtitle', 'story_paragraph_1', 'story_paragraph_2',
    'story_image', 'vision', 'mission',
])]
class AboutContent extends Model
{
    // Singleton: the About page has exactly one content row, created on
    // first access so the Filament settings page always has something to edit.
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
