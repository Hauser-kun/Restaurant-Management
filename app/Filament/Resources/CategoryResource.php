<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = "Restaurant";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Select::make('status')
                    ->options([
                        "0" => "Inactive",
                        "1" => "Active",
                    ])
                    ->default(1)
                    ->label('Status'),

                Hidden::make('restaurant_id')  // Assuming you are saving the category ID
                    // ->label('Category')
                    ->default(Auth::user()->restaurant_id)
                    ->dehydrated(true)
                // ->relationship('restaurant', 'name') // Fetch category name using the 'category' relationship
                // ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn() => Category::where('restaurant_id', Auth::user()->restaurant_id))
            ->columns([
                TextColumn::make('name'),
                SelectColumn::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Deactive'
                    ]),
                TextColumn::make('restaurant_id')
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
