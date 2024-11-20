<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Restaurant;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RestaurantResource\Pages;
use App\Filament\Resources\RestaurantResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Auth;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return Auth::user()->id == 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->image() // Ensures only image files are allowed
                    ->directory('restaurants') // Directory where the image will be stored
                    ->required(false) // Make it optional
                    ->maxSize(1024) // Max file size in KB
                    ->label('Logo')
                ,
                TextInput::make('officeName'),
                TextInput::make('email')
                    ->email()
                    ->nullable(),
                TextInput::make('contact')
                    ->nullable(),
                TextInput::make('pan')->integer(),
                TextInput::make('vatPer')->integer()
                ->default(0),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                ->disk('public')
                ->url(fn($record) => asset('storage/restaurants/' . $record->image))
                ->label('Restaurant Image')
                ->sortable()
                ->label('Logo'),
                TextColumn::make('name'),
                TextColumn::make('officeName'),
                TextColumn::make('email'),

                TextColumn::make('contact'),
                TextColumn::make('pan')
                ,
                TextColumn::make('vatPer')
                ,

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
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }
}
