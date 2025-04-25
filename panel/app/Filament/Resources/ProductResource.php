<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-Beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                        
                    Forms\Components\Select::make('brand_id')
                        ->relationship('brand', 'name')
                        ->searchable()
                        ->required(),
                        
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->required(),
                ])->columns(2),
                
            Forms\Components\Section::make('Pricing & Inventory')
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->required()
                        ->prefix('$'),
                        
                    Forms\Components\TextInput::make('stock')
                        ->numeric()
                        ->minValue(0)
                        ->required(),
                ])->columns(2),
                
            Forms\Components\Section::make('Media & Attributes')
                ->schema([
                    Forms\Components\FileUpload::make('images')
                        ->multiple()
                        ->image()
                        ->directory('products')
                        ->reorderable()
                        ->downloadable()
                        ->columnSpanFull(),
                        
                    Forms\Components\KeyValue::make('season_data')
                        ->keyLabel('Season/Time') // e.g. "summer"
                        ->valueLabel('Percentage') // e.g. "70"
                        ->addActionLabel('Add Season')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                ->stacked()
                ->limit(1)
                ->circular(),
                
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('brand.name')
                ->sortable(),
                
            Tables\Columns\TextColumn::make('price')
                ->money('USD')
                ->sortable(),
                
            Tables\Columns\TextColumn::make('stock')
                ->numeric()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('order_items_count')
                ->counts('orderItems')
                ->label('Orders')
                ->sortable(),
                
            Tables\Columns\TextColumn::make('ratings_avg_rating')
                ->avg('ratings', 'rating')
                ->label('Avg Rating')
                ->numeric(1)
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('brand')
                ->relationship('brand', 'name'),
                
            Tables\Filters\SelectFilter::make('category')
                ->relationship('category', 'name'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
