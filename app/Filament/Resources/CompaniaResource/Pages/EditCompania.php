<?php

namespace App\Filament\Resources\CompaniaResource\Pages;

use App\Filament\Resources\CompaniaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompania extends EditRecord
{
    protected static string $resource = CompaniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
