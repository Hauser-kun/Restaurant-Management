<?php

namespace App\Filament\Resources\RtableResource\Pages;

use App\Filament\Resources\RtableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRtable extends EditRecord
{
    protected static string $resource = RtableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
