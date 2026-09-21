<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\ManageServices;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung Website';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('icon')
                    ->label('Icon (PrimeIcons)')
                    ->helperText('Tên icon từ primeicons, ví dụ: pi-code, pi-cloud, pi-shield.')
                    ->required(),
                TextInput::make('title')->required(),
                Textarea::make('description')->rows(3)->required(),
                TextInput::make('order')->numeric()->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                TextColumn::make('icon'),
                TextColumn::make('title')->searchable(),
                TextColumn::make('description')->limit(60),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageServices::route('/'),
        ];
    }
}
