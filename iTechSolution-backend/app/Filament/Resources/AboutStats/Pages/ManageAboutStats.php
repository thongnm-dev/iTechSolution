<?php

namespace App\Filament\Resources\AboutStats\Pages;

use App\Filament\Resources\AboutStats\AboutStatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAboutStats extends ManageRecords
{
    protected static string $resource = AboutStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
