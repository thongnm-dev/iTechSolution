<?php

namespace App\Filament\Resources\AboutValues;

use App\Filament\Resources\AboutValues\Pages\ManageAboutValues;
use App\Models\AboutValue;
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

class AboutValueResource extends Resource
{
    protected static ?string $model = AboutValue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Trang Giới thiệu';

    protected static ?string $navigationLabel = 'Giá trị cốt lõi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('icon')
                    ->label('Icon (PrimeIcons)')
                    ->helperText('Ví dụ: pi-verified, pi-bolt, pi-heart, pi-users.')
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
            'index' => ManageAboutValues::route('/'),
        ];
    }
}
