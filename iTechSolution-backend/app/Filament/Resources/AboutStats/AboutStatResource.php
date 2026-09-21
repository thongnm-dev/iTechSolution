<?php

namespace App\Filament\Resources\AboutStats;

use App\Filament\Resources\AboutStats\Pages\ManageAboutStats;
use App\Models\AboutStat;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutStatResource extends Resource
{
    protected static ?string $model = AboutStat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Trang Giới thiệu';

    protected static ?string $navigationLabel = 'Số liệu thống kê';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('value')->label('Số liệu (ví dụ: 10+)')->required(),
                TextInput::make('label')->required(),
                TextInput::make('order')->numeric()->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                TextColumn::make('value'),
                TextColumn::make('label')->searchable(),
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
            'index' => ManageAboutStats::route('/'),
        ];
    }
}
