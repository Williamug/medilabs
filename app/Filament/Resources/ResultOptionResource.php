<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultOptionResource\Pages;
use App\Filament\Resources\ResultOptionResource\RelationManagers;
use App\Models\ResultOption;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResultOptionResource extends Resource
{
    protected static ?int $navigationSort = 1;

    protected static ?string $model = ResultOption::class;

    protected static ?string $navigationIcon = 'tabler-list-details';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('option')
                    ->unique(column: 'option')
                    ->minLength(3)
                    ->maxLength(255)
                    ->placeholder('(Ex. positive)')
                    ->required(),
                TextInput::make('code')
                    ->placeholder('(Ex. +ve)')
                    ->required(),
                TextInput::make('symbol')
                    ->placeholder('(Ex. +)')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('option')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code'),
                TextColumn::make('symbol'),
                TextColumn::make('created_at')
                    ->label('Created On')
                    ->dateTime('D, d M Y | H:i:s'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageResultOptions::route('/'),
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
