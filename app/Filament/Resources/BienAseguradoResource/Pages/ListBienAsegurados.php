<?php

namespace App\Filament\Resources\BienAseguradoResource\Pages;

use App\Filament\Resources\BienAseguradoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBienAsegurados extends ListRecords
{
    protected static string $resource = BienAseguradoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
