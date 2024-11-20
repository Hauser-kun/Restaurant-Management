<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rtable;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Restaurant";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('Mprice')
                ->label('Mark Price')
                    ->required(),
                TextInput::make('Sprice')
                ->label('Selling Price')
                    ->required(),
                TextInput::make('description')
                    ->nullable(),
                Select::make('Status')
                    ->options([
                        0 => 'Inactive',
                        1 => 'Active',
                    ])
                    ->nullable(),

                // Select::make('category_id')  // Assuming you are saving the category ID
                //     ->label('Category')
                //     ->options(Category::where('restaurant_id', Auth::user()->restaurant_id)->pluck('name', 'id'))
                //     // ->relationship('category', 'name') // Fetch category name using the 'category' relationship
                //     ->required(),

                Select::make('category_id')
                    ->label('Category')
                    ->options(function () {
                        return Category::where('restaurant_id', Auth::user()->restaurant_id)->pluck('name', 'id');
                    })
                    ->required()
                    ->searchable()




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Product::whereHas('category', function ($query) {
                    $query->where('restaurant_id', Auth::user()->restaurant_id);
                });
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Restaurant Name')
                    ->sortable(),
                TextColumn::make('Mprice')
                    ->label('Mark Price')
                    ->sortable(),
                TextColumn::make('Sprice')
                    ->label('Selling Price')
                    ->sortable(),

                SelectColumn::make('Status')
                    ->options([
                        0 => 'Inactive',
                        1 => 'Active',
                    ]),

                // SelectColumn::make('category_id')
                // ->relationship('category','name')

                // TextColumn::make('category_id')
                // ->relationship('category', 'name'),

                TextColumn::make('category.name') // Access the 'name' field from the related Restaurant model
                    ->label('Category Name')
                    ->sortable()
                    ->searchable(),



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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
