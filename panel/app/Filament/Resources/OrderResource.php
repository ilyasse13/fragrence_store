<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-list';

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
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
                
            Tables\Columns\TextColumn::make('customer.name')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('total_price')
                ->money('USD')
                ->sortable(),
                
            Tables\Columns\SelectColumn::make('status')
                ->options([
                    'pending' => 'Pending',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered'
                ]),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('items_count')
                ->label('Items')
                ->counts('items')
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered'
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
