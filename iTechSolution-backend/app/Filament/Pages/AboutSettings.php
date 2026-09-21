<?php

namespace App\Filament\Pages;

use App\Models\AboutContent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AboutSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.about-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Trang Giới thiệu';

    protected static ?string $navigationLabel = 'Nội dung trang Giới thiệu';

    protected static ?string $title = 'Nội dung trang Giới thiệu';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutContent::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('hero_title')->label('Tiêu đề')->required(),
                        Textarea::make('hero_subtitle')->label('Mô tả ngắn')->rows(2),
                    ]),
                Section::make('Câu chuyện công ty')
                    ->schema([
                        FileUpload::make('story_image')->label('Ảnh')->image()->directory('about'),
                        Textarea::make('story_paragraph_1')->label('Đoạn 1')->rows(4),
                        Textarea::make('story_paragraph_2')->label('Đoạn 2')->rows(4),
                    ]),
                Section::make('Tầm nhìn & Sứ mệnh')
                    ->schema([
                        Textarea::make('vision')->label('Tầm nhìn')->rows(3),
                        Textarea::make('mission')->label('Sứ mệnh')->rows(3),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        AboutContent::current()->update($this->form->getState());

        Notification::make()->title('Đã lưu nội dung trang Giới thiệu')->success()->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')->label('Lưu')->action('save'),
        ];
    }
}
