<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\Section as InfoListSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Grid as InfoListGrid;
use Filament\Infolists\Components\Group as InfoListGroup;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?int $navigationSort = 5;

    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                // patient number
                                TextInput::make('patient_number')
                                    ->default(function () {
                                        do {
                                            $number = random_int(
                                                100000,
                                                999999
                                            );
                                        } while (Patient::where('patient_number', '=', $number)->first());
                                        return $number;
                                    })
                                    ->disabled()
                                    ->dehydrated(),
                                // full name
                                TextInput::make('full_name')
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->required(),
                                // gender
                                Radio::make('gender')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female'
                                    ])
                                    ->required(),
                                // phone number
                                TextInput::make('phone_number')
                                    ->tel(),
                                // email
                                TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->maxLength(255),
                                // residence
                                TextInput::make('residence')
                                    ->maxLength(255),

                                // select date of birth or age
                                Select::make('birth_date')
                                    ->options([
                                        'date_of_birth' => 'Date of birth',
                                        'age' => 'Age',
                                    ])
                                    ->live()
                                    ->afterStateUpdated(fn (Select $component) => $component
                                        ->getContainer()
                                        ->getComponent('dynamicTypeFields')
                                        ->getChildComponentContainer()
                                        ->fill()),

                                Grid::make(2)
                                    ->schema(fn (Get $get): array => match ($get('birth_date')) {
                                        'date_of_birth' => [
                                            DatePicker::make('date_of_birth')
                                                ->required(),
                                        ],
                                        'age' => [
                                            TextInput::make('age')
                                                ->numeric()
                                                ->required(),
                                        ],
                                        default => [],
                                    })
                                    ->key('dynamicTypeFields'),


                                // Select::make('blog_author_id')
                                //     ->relationship('author', 'name')
                                //     ->searchable()
                                //     ->required(),


                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => fn (?Patient $record) => $record === null ? 3 : 2]),


                // Section::make()
                //     ->schema([
                //         // temperature
                //         TextInput::make('temperature')
                //             ->numeric(),
                //         // weight
                //         TextInput::make('weight')
                //             ->numeric(),
                //         // height
                //         TextInput::make('height')
                //             ->numeric(),
                //     ])
                //     ->columns(2),

                // Section::make()
                //     ->schema([
                //         // next of kin
                //         Select::make('next_of_kin_id')
                //             ->relationship('next_of_kins', 'name')
                //             ->searchable()
                //             ->preload()
                //             ->createOptionForm([
                //                 // name
                //                 TextInput::make('name')
                //                     ->required()
                //                     ->maxLength(255),
                //                 // gender
                //                 Radio::make('gender')
                //                     ->options([
                //                         'Male' => 'Male',
                //                         'Female' => 'Female'
                //                     ])
                //                     ->inline()
                //                     ->required(),
                //                 // relationship to patient
                //                 TextInput::make('relationship_to_patient')
                //                     ->required()
                //                     ->maxLength(255),
                //                 // phone number
                //                 TextInput::make('phone_number')
                //                     ->label('Phone number')
                //                     ->tel(),
                //                 // email
                //                 TextInput::make('email')
                //                     ->label('Email Address')
                //                     ->email()
                //                     ->maxLength(255),
                //                 // residence
                //                 TextInput::make('residence')
                //                     ->maxLength(255),
                //             ])
                //             ->required(),
                //     ])
                //     ->columns(2),


                Section::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Patient $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Patient $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Patient $record) => $record === null),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient_number'),
                TextColumn::make('full_name'),
                TextColumn::make('gender'),
                TextColumn::make('phone_number'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoListSection::make('Patient Info')
                    ->schema([
                        Split::make([
                            InfoListGrid::make(2)
                                ->schema([
                                    InfoListGroup::make([
                                        TextEntry::make('patient_number')
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('full_name')
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('gender')
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('date_of_birth')
                                            ->weight(FontWeight::Bold),
                                    ]),
                                    InfoListGroup::make([
                                        TextEntry::make('phone_number')
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('email')
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('residence')
                                            ->weight(FontWeight::Bold),
                                    ]),
                                ]),
                        ])->from('lg'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VisitsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
