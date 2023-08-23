<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestOrderResource\Pages;
use App\Filament\Resources\TestOrderResource\RelationManagers;
use App\Models\TestOrder;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestOrderResource extends Resource
{
    protected static ?string $model = TestOrder::class;
    protected static ?string $navigationGroup = 'Laboratory';
    protected static ?string $navigationIcon = 'fluentui-clipboard-clock-24-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lab_service.service_name'),
                TextColumn::make('order_number'),
                TextColumn::make('order_status')
                    ->label('Order Status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'warning',
                        'received' => 'success',
                    }),
                TextColumn::make('created_at')
                    ->label('Order date')
                    ->label('Submitted On')
                    ->dateTime('D, d M Y | H:i:s')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Action::make('Receive Order')
                    ->label(function (Model $record) {
                        if ($record->order_status === 'submitted') {
                            return 'Receive Order';
                        }
                        return '';
                    })
                    ->action(function (Model $record, array $data): Model {
                        $record->update([
                            'order_status' => 'received',
                        ]);

                        return $record;
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTestOrders::route('/'),
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
