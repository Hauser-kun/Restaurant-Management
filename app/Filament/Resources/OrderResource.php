<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Category;
use App\Models\Order;
use App\Models\Rtable;
use Filament\Forms;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = "Orders Management";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('table_id')
                ->options(function(){
                    return Rtable::where('restaurant_id',Auth::user()->restaurant_id)->pluck('name', 'id');
                })
                ,
                TextInput::make('customerName'),
                TextInput::make('customerContact')
                ->integer(),
                TextInput::make('total')
                ->required()
                ->integer(),
                TextInput::make('vat')
                ->default(0)
                ->integer(),
               
                TextInput::make('discountTotal')
                ->integer(),
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(function () {
            return Order::whereHas('table', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            });
        })
            ->columns([    
                // TextColumn::make('tableId'),
                TextColumn::make('table.name')
                ->label('Table No')
                ->sortable()
                ->searchable(),
                TextColumn::make('customerName')
                ->searchable(),
                TextColumn::make('customerContact'),
                TextColumn::make('vat'),
                TextColumn::make('discountTotal'),
                TextColumn::make('total'),
                
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
