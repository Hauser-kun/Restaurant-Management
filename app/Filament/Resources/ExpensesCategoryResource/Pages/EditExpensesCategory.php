<?php

namespace App\Filament\Resources\ExpensesCategoryResource\Pages;

use App\Filament\Resources\ExpensesCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpensesCategory extends EditRecord
{
    protected static string $resource = ExpensesCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
