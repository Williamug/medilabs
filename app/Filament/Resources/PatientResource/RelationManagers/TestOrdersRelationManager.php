<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use App\Models\LabService;
use App\Models\TestOrder;
use Filament\Actions\CreateAction;
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
                TextInput::make('order_number')
                    ->default(function () {
                        do {
                            $number = random_int(
                                100000,
                                999999
                            );
                        } while (TestOrder::where('order_number', '=', $number)->first());
                        return $number;
                    })
                    ->disabled()
                    ->dehydrated(),
                Select::make('lab_service_id')
                    ->label('Lab service')
                    ->options(function () {
                        return LabService::all()->pluck('service_name', 'id');
                    })
                    ->searchable()
                    ->string()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lab_service_id')
            ->columns([
                TextColumn::make('lab_service.service_name')
                    ->sortable(),
                TextColumn::make('lab_service.price')
                    ->label('Price')
                    ->money('UGX'),
                TextColumn::make('created_at')
                    ->label('Submitted On')
                    ->dateTime('D, d M Y | H:i:s')
                    ->sortable(),
                TextColumn::make('order_number'),
                TextColumn::make('order_staus')
                    ->label('Order Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'received' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Unpaid' => 'danger',
                        'paid' => 'success',
                    }),
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
