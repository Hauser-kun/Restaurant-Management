<?php

namespace App\Filament\Resources\RtableResource\Pages;

use App\Filament\Resources\RtableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRtables extends ListRecords
{
    protected static string $resource = RtableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
