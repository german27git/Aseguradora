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
            Actions\DeleteAction::make()
                ->label("Eliminar"),
        ];
    }
    
        // <-- Con esta funcion generamos el titulo del listado
    public function getTitle(): string
    {
        return 'Editar Compania';
    }

    //Ocultamos el getBreadcrumbs que muestra en la parte sup la ruta
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
