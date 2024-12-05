<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillingResource\Pages;
use App\Filament\Resources\BillingResource\RelationManagers\ServiceChargesRelationManager;
use App\Models\Billing;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BillingResource extends Resource
{
    protected static ?string $model = Billing::class;

    protected static ?string $slug = 'billings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('period_starts_at')
                    ->label('Period Starts Date'),

                DatePicker::make('period_ends_at')
                    ->label('Period Ends Date'),

                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup(Group::make('location.name')->collapsible())
            ->columns([
//                TextColumn::make('location.name')
//                    ->searchable()
//                    ->sortable(),

                TextColumn::make('period_starts_at')
                    ->label('Period Starts Date')
                    ->date(),

                TextColumn::make('period_ends_at')
                    ->label('Period Ends Date')
                    ->date(),
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
            'index' => Pages\ListBillings::route('/'),
            'create' => Pages\CreateBilling::route('/create'),
            'edit' => Pages\EditBilling::route('/{record}/edit'),
            'view' => Pages\ViewBilling::route('/{record}'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['location']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['location.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->location) {
            $details['Location'] = $record->location->name;
        }

        return $details;
    }

    public static function getRelations(): array
    {
        return [
            ServiceChargesRelationManager::class,
        ];
    }
}
