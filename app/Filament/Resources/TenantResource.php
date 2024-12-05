<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Models\Location;
use App\Models\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $slug = 'tenants';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->required(),

                TextInput::make('base_rent')
                    ->numeric()
                    ->required(),

                TextInput::make('additional_costs')
                    ->numeric()
                    ->required(),

                DatePicker::make('started_at')
                    ->label('Started Date'),

                DatePicker::make('ended_at')
                    ->label('Ended Date'),

                Placeholder::make('created_at')
                    ->label('Created Date'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('base_rent'),

                TextColumn::make('additional_costs'),

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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'view' => Pages\ViewTenant::route('/{record}'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['location']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->location) {
            $details['Location'] = $record->location->name;
        }

        return $details;
    }
}
