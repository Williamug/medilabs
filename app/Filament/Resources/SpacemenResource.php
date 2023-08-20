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
    protected static ?int $navigationSort = 4;

    protected static ?string $model = Spacemen::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('spacemen')
                    ->unique(table: Spacemen::class)
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
                    ->dateTime('D, d M Y | H:i:s'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSpacemens::route('/'),
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
