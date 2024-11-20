<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use App\Models\Expenses;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ExpensesCategory;
use Filament\Resources\Resource;
use App\Models\Expenses_Category;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ExpensesCategoryResource\Pages;
use App\Filament\Resources\ExpensesCategoryResource\RelationManagers;

class ExpensesCategoryResource extends Resource
{
    protected static ?string $model = Expenses_Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Expenses";
    protected static ?string $label = "Expenses Categories";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('details'),

                Select::make('status')
                    ->options([
                        "0" => 'Inactive',
                        "1" => 'Active'

                    ])
                    ->default(1)
                    ->label('Status'),

                Hidden::make('restaurant_id')
                    ->default(fn() => Auth::user()?->restaurant_id)
                    ->dehydrated(true)




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn() => Expenses_Category::where('restaurant_id', Auth::user()?->restaurant_id))

            ->columns([
                TextColumn::make('name'),
                TextColumn::make('details'),
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
            'index' => Pages\ListExpensesCategories::route('/'),
            'create' => Pages\CreateExpensesCategory::route('/create'),
            'edit' => Pages\EditExpensesCategory::route('/{record}/edit'),
        ];
    }
}