<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Nuevo Usuario"),
        ];
    }

        // <-- Con esta funcion generamos el titulo del listado
    public function getTitle(): string
    {
        return 'Listado de Usuarios';
    }

    //Ocultamos el getBreadcrumbs que muestra en la parte sup la ruta
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
