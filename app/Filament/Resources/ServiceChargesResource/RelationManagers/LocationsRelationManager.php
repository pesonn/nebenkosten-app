<?php

namespace App\Filament\Resources\ServiceChargesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'locations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('proportional')
                        ->required()
                        ->numeric()
                        ->maxLength(50)
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('proportional_unit')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),
                ])->columns(2)->columnSpanFull(),
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('amount')
                        ->numeric()
                        ->columnSpan(1),
                ])->columns(2)->columnSpanFull(),
                Forms\Components\Group::make([
                    Forms\Components\CheckboxList::make('related_meter_readers')->options(
                        fn($record) => $record->meterReaders->pluck('meter_number')
                    ),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('proportional'),
                Tables\Columns\TextColumn::make('proportional_unit'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                /*  Tables\Actions\AttachAction::make()
                      ->preloadRecordSelect()
                      ->form(fn(Tables\Actions\AttachAction $action): array => [
                          $action->getRecordSelect(),
                          Forms\Components\TextInput::make('proportional')->required()->numeric(),
                          Forms\Components\TextInput::make('proportional_unit')->required(),
                      ]),*/
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
