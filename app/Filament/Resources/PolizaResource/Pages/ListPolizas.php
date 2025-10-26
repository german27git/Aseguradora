<?php

namespace App\Filament\Resources\PolizaResource\Pages;

use App\Filament\Resources\PolizaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolizas extends ListRecords
{
    protected static string $resource = PolizaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Nueva Poliza"),
        ];
    }

        // <-- Con esta funcion generamos el titulo del listado
    public function getTitle(): string
    {
        return 'Listado de Polizas';
    }

    //Ocultamos el getBreadcrumbs que muestra en la parte sup la ruta
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
