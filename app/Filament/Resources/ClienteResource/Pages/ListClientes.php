<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientes extends ListRecords
{
    protected static string $resource = ClienteResource::class;

    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo cliente'),
        ];
    }

    // <-- Con esta funcion generamos el titulo del listado
    public function getTitle(): string
    {
        return 'Listado de Clientes';
    }

    //Ocultamos el getBreadcrumbs que muestra en la parte sup la ruta
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
