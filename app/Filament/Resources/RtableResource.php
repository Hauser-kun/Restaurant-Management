<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RtableResource\Pages;
use App\Filament\Resources\RtableResource\RelationManagers;
use App\Models\Restaurant;
use App\Models\Rtable;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RtableResource extends Resource
{
    protected static ?string $model = Rtable::class;

    protected static ?string $label = "Tables";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationGroup = "Orders Management";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('capacity')
                ->integer(),
                TextInput::make('available')
                ->integer(),
                // Hidden::make('cuisine_type')
                // ->label('Select Category')
                // ->relationship('restaurant','name')
                // ->required(), // Make it required if needed
                

                Hidden::make('restaurant_id')  // Assuming you are saving the category ID
                    ->label('Category')
                    ->default(Auth::user()->restaurant_id)
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        // ->query(fn() => Restaurant::where('restaurant_id', Auth::user()->restaurant_id))
        ->query(fn() => Rtable::where('restaurant_id', Auth::user()->restaurant_id))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('capacity'),
                TextColumn::make('available'),
                TextColumn::make('restaurant_id'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRtables::route('/'),
            'create' => Pages\CreateRtable::route('/create'),
            'edit' => Pages\EditRtable::route('/{record}/edit'),
        ];
    }
}
