<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'category', 'description', 'image', 'order'])]
class Project extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('order'));
    }
}
