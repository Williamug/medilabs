<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabServiceCategoryResource\RelationManagers\CategoryNameRelationManager;
use App\Filament\Resources\LabServiceResource\Pages;
use App\Filament\Resources\LabServiceResource\RelationManagers;
use App\Models\LabService;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabServiceResource extends Resource
{
    protected static ?string $model = LabService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('service_category_id')
                            ->relationship('service_category', 'category_name')
                            ->placeholder('Select service category')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('category_name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->required(),
                    ]),
                TextInput::make('service_name')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('price')
                    ->mask(RawJs::make(<<<'JS'
        $money($input)
    JS))
                    ->alphaNum()
                    ->prefix('UGX.')
                    ->minValue(3)
                    ->maxValue(42949672.95),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_category.category_name')
                    ->searchable(),
                TextColumn::make('service_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('UGX')
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabServices::route('/'),
            'create' => Pages\CreateLabService::route('/create'),
            'edit' => Pages\EditLabService::route('/{record}/edit'),
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
