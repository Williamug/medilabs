<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientVisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'patient_visits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // next of kin
                Fieldset::make('Next of kin')
                    ->schema([
                        // name
                        TextInput::make('next_of_kin_name')
                            ->label('Name')
                            ->maxLength(255),

                        // relationship to patient
                        TextInput::make('relation_to_patient')
                            ->label('Relationship to patient')
                            ->maxLength(255),


                        // phone number
                        TextInput::make('next_of_kin_phone_number')
                            ->label('Phone Number')
                            ->maxLength(255),

                        // residence
                        TextInput::make('next_of_kin_residence')
                            ->label('Residence')
                            ->maxLength(255),
                    ])
                    ->columns(4),

                // measurements
                Fieldset::make('Body measurements')
                    ->schema([
                        TextInput::make('temperature')
                            ->numeric()
                            ->maxLength(255),
                        TextInput::make('weight')
                            ->numeric()
                            ->maxLength(255),
                        TextInput::make('height')
                            ->numeric()
                            ->maxLength(255),
                    ])
                    ->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('temperature')
            ->columns([
                TextColumn::make('temperature'),
                TextColumn::make('weight'),
                TextColumn::make('height'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
