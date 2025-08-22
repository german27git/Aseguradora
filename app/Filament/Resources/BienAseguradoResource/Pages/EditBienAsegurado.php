<?php

namespace App\Filament\Resources\BienAseguradoResource\Pages;

use App\Filament\Resources\BienAseguradoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBienAsegurado extends EditRecord
{
    protected static string $resource = BienAseguradoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
