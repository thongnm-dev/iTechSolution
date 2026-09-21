<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\AboutStat;
use App\Models\AboutValue;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $content = AboutContent::current();

        return [
            'heroTitle' => $content->hero_title,
            'heroSubtitle' => $content->hero_subtitle,
            'storyParagraphs' => array_values(array_filter([
                $content->story_paragraph_1,
                $content->story_paragraph_2,
            ])),
            'storyImage' => $content->story_image ? Storage::disk('public')->url($content->story_image) : null,
            'vision' => $content->vision,
            'mission' => $content->mission,
            'values' => AboutValue::all()->map(fn (AboutValue $value) => [
                'icon' => $value->icon,
                'title' => $value->title,
                'description' => $value->description,
            ]),
            'stats' => AboutStat::all()->map(fn (AboutStat $stat) => [
                'value' => $stat->value,
                'label' => $stat->label,
            ]),
        ];
    }
}
