<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpacemenResource\Pages;
use App\Filament\Resources\SpacemenResource\RelationManagers;
use App\Models\Spacemen;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpacemenResource extends Resource
{
    protected static ?int $navigationSort = 3;

    protected static ?string $model = Spacemen::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('spacemen')
                    ->minLength(3)
                    ->maxLength(255)
                    ->placeholder('(Ex. Blood)')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('spacemen'),
                TextColumn::make('created_at')
                    ->dateTime('D, d M Y H:i:s'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpacemens::route('/'),
            'create' => Pages\CreateSpacemen::route('/create'),
            'edit' => Pages\EditSpacemen::route('/{record}/edit'),
        ];
    }
}
