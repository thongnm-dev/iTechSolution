<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['icon', 'image', 'title', 'description', 'order'])]
class Service extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('order'));
    }
}
