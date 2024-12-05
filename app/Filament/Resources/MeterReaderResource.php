<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeterReaderResource\Pages;
use App\Models\MeterReader;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeterReaderResource extends Resource
{
    protected static ?string $model = MeterReader::class;

    protected static ?string $slug = 'meter-readers';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?MeterReader $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?MeterReader $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('meter_number')
                    ->required(),

                TextInput::make('description')
                    ->required(),

                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->searchable(['name', 'address'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meter_number'),

                TextColumn::make('description'),

                TextColumn::make('location'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeterReaders::route('/'),
            'create' => Pages\CreateMeterReader::route('/create'),
            'edit' => Pages\EditMeterReader::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
