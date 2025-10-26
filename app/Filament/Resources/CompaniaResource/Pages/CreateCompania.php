<?php

namespace App\Filament\Resources\CompaniaResource\Pages;

use App\Filament\Resources\CompaniaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompania extends CreateRecord
{
    protected static string $resource = CompaniaResource::class;


    // <-- Con esta funcion generamos el titulo del listado
    public function getTitle(): string
    {
        return 'Crear Compania';
    }

    //Ocultamos el getBreadcrumbs que muestra en la parte sup la ruta
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
