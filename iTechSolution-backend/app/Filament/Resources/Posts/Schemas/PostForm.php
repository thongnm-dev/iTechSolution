<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Post')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Content')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Textarea::make('excerpt')
                                    ->rows(3)
                                    ->maxLength(500),
                                RichEditor::make('content')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Publishing')
                            ->schema([
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                        TextInput::make('slug')->required(),
                                    ]),
                                Select::make('author_id')
                                    ->label('Author')
                                    ->relationship('author', 'name')
                                    ->default(fn () => auth()->id())
                                    ->searchable()
                                    ->required(),
                                Select::make('tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                        TextInput::make('slug')->required(),
                                    ]),
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                    ])
                                    ->default('draft')
                                    ->live()
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->visible(fn (callable $get) => $get('status') === 'published')
                                    ->default(now()),
                                FileUpload::make('cover_image')
                                    ->image()
                                    ->directory('posts'),
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('seo_title')->maxLength(255),
                                Textarea::make('seo_description')->rows(3)->maxLength(500),
                                FileUpload::make('og_image')
                                    ->image()
                                    ->directory('posts/og'),
                            ]),
                    ]),
            ]);
    }
}
