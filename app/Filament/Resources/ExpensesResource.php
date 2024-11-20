<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesResource\Pages;
use App\Filament\Resources\ExpensesResource\RelationManagers;
use App\Models\Expenses;
use App\Models\Expenses_Category;
use Filament\Forms;
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

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Expenses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('expenses_category_id')
                ->label('Expenses Categories')
                ->required()
                ->options(function () {
                    return Expenses_Category::where('restaurant_id', Auth::user()->restaurant_id)->pluck('name', 'id');
                }),
                TextInput::make('title')
                ->required(),
                TextInput::make('info'),
                TextInput::make('remark'),
                TextInput::make('amount')
                ->integer()
                ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        // ->query(fn() => Expenses::whereHas('categoryExpenses', fn($query) => $query->where('restaurant_id', Auth::user()?->restaurant_id)))
        ->query(function () {
            return Expenses::whereHas('categoryExpenses', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            });
        })

        // ->query(fn() => Expenses::where('restaurant_id', Auth::user()?->restaurant_id))
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('info'),
                TextColumn::make('remark'),
                TextColumn::make('amount'),

                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpenses::route('/create'),
            'edit' => Pages\EditExpenses::route('/{record}/edit'),
        ];
    }
}
