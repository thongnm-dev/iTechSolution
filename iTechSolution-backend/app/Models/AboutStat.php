<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['value', 'label', 'order'])]
class AboutStat extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('order'));
    }
}
