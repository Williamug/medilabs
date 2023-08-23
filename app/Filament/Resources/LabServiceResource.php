<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabServiceResource\Pages;
use App\Filament\Resources\LabServiceResource\RelationManagers;
use App\Models\LabService;
use App\Models\LabServiceCategory;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
    protected static ?int $navigationSort = 3;

    protected static ?string $model = LabService::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lab_service_category_id')
                    ->relationship('lab_service_category', 'category_name')
                    ->placeholder('Select service category')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('category_name')
                            ->required()
                            ->unique(table: LabServiceCategory::class)
                            ->maxLength(255),
                    ])
                    ->required(),
                TextInput::make('service_name')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('price')
                    // ->mask(RawJs::make(<<<'JS'
                    //     $money($input)
                    // JS))
                    ->prefix('UGX.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lab_service_category.category_name')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLabServices::route('/'),
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
