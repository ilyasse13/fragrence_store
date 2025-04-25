<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Brand Information')
                ->description('Enter Basic brand details')
                ->schema([
                    TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord:true)
                    ->columnSpanFull(),
                    FileUpload::make('logo_url')
            ->label('Brand Logo')
            ->directory('brands/logos') // Saves to storage/app/public/brands/logos
            ->image()
            ->imageEditor() // Enables image cropping/editing
            ->imagePreviewHeight('250') // Preview size
            ->downloadable() // Allows users to download the image
            ->openable() // Allows viewing in modal
            ->maxSize(2048) // 2MB limit in KB
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->helperText('Upload a high-quality logo (max 2MB)')
            ->columnSpanFull(),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_url')
                ->label('')
                ->disk('public')
                ->width(40)
                ->height(40),
            
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            
            Tables\Columns\TextColumn::make('products_count')
                ->label('Products')
                ->counts('products')
                ->numeric()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
