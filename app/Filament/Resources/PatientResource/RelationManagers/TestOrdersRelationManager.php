<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use App\Models\LabService;
use App\Models\TestOrder;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'test_orders';

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

                // test order
                Repeater::make('lab_service_test_orders')
                    ->relationship()
                    ->schema([
                        Select::make('lab_service_id')
                            ->relationship('lab_service', 'service_name'),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lab_service_id')
            ->columns([
                TextColumn::make('lab_service')
                    ->state(function (Model $record) {
                        foreach ($record->lab_services as $lab_service) {
                            return $lab_service->service_name;
                        }
                    }),
                TextColumn::make('created_at'),
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
