<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\RelationManagers\MeterReadersRelationManager;
use App\Filament\Resources\ServiceChargesResource\Pages;
use App\Filament\Resources\ServiceChargesResource\RelationManagers\BillingsRelationManager;
use App\Filament\Resources\ServiceChargesResource\RelationManagers\LocationsRelationManager;
use App\Models\Location;
use App\Models\ServiceCharges;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ServiceChargesResource extends Resource
{
    protected static ?string $model = ServiceCharges::class;

    protected static ?string $slug = 'service-charges-resource_s';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->required(),

                Select::make('service_type_id')
                    ->relationship('serviceType', 'name')
                    ->required(),

                DatePicker::make('period_started_at')
                    ->label('Period Started Date')
                    ->required(),

                DatePicker::make('period_ended_at')
                    ->label('Period Ended Date')
                    ->required(),

                TextInput::make('amount')
                    ->required()
                    ->numeric(),

                TextInput::make('total_usage')
                    ->required()
                    ->numeric(),

                TextInput::make('usage_unit')
                    ->required(),

                DatePicker::make('payed_at')
                    ->label('Payed Date'),

                FileUpload::make('file_path')
                    ->openable(),

                Select::make('locations')->relationship(titleAttribute: 'name')
                    ->multiple()
                    ->preload()
                    ->live(),

                Select::make('meterReaders')
                    ->hidden(fn(Get $get): bool => !$get('locations'))
                    ->relationship(
                        'meterReaders',
                        'meter_number',
                        fn($query, Get $get) => $query->whereHas('location', function ($query) use ($get) {
                            $selectedLocations = $get('locations');
                            $query->whereIn('id', $selectedLocations);
                        })
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn(Model $record) => "{$record->meter_number} ({$record->location->name})"
                    )
                    ->multiple()
                    ->preload(),

//                Placeholder::make('created_at')
//                    ->label('Created Date')
//                    ->content(fn(?ServiceCharges $record): string => $record?->created_at?->diffForHumans() ?? '-'),
//
//                Placeholder::make('updated_at')
//                    ->label('Last Modified Date')
//                    ->content(fn(?ServiceCharges $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider.name'),

                TextColumn::make('serviceType.name'),

                TextColumn::make('file_path'),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
                        DeleteAction::make(),
                    ]
                ),
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
            'index' => Pages\ListServiceChargesResource_s::route('/'),
            'create' => Pages\CreateServiceChargesResource::route('/create'),
            'view' => Pages\ViewServiceCharges::route('/{record}'),
            'edit' => Pages\EditServiceChargesResource::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            LocationsRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
