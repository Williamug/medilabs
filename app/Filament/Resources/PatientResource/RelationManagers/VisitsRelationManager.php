<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use App\Models\LabService;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Measurements')
                    ->schema([

                        // temperature
                        TextInput::make('temperature')
                            ->numeric(),
                        // weight
                        TextInput::make('weight')
                            ->numeric(),
                        // height
                        TextInput::make('height')
                            ->numeric(),
                    ])
                    ->columns(3),

                Fieldset::make('Next of kin')
                    ->schema([
                        // next_of_kin_name
                        TextInput::make('next_of_kin_name')
                            ->label('Name')
                            ->maxLength(255),
                        // next_of_kin_gender
                        Radio::make('next_of_kin_gender')
                            ->label('Gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female'
                            ]),
                        // relationship_to_patient
                        TextInput::make('relationship_to_patient')
                            ->maxLength(255),
                        // next_of_kin_phone_number
                        TextInput::make('next_of_kin_phone_number')
                            ->label('Phone Number')
                            ->maxLength(255),
                        // next_of_kin_residence
                        TextInput::make('next_of_kin_residence')
                            ->label('Residence')
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Fieldset::make('Test Order(s)')
                    ->schema([
                        Select::make('id')
                            ->label('Lab service')
                            ->multiple()
                            ->options(LabService::all()->pluck('service_name'))
                            ->searchable()
                        // ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('temperature')
            ->columns([
                TextColumn::make('temperature'),
                TextColumn::make('weight'),
                TextColumn::make('height'),
                TextColumn::make('created_at')
                    ->label('Visited At')
                    ->dateTime('D, d M Y | H:i:s'),
                TextColumn::make('next_of_kin_name'),
                TextColumn::make('next_of_kin_phone_number')
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
