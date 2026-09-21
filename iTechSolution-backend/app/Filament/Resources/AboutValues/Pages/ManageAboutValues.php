<?php

namespace App\Filament\Resources\AboutValues\Pages;

use App\Filament\Resources\AboutValues\AboutValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAboutValues extends ManageRecords
{
    protected static string $resource = AboutValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
