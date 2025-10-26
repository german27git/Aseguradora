<?php

namespace App\Filament\Resources\CompaniaResource\Pages;

use App\Filament\Resources\CompaniaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanias extends ListRecords
{
    protected static string $resource = CompaniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Nueva Compania"),
        ];
    }

        public function getTitle(): string
    {
        return 'Listado de Companias';
    }

    //Ocultamos el getBreadcrumbs que muestra en la parte sup la ruta
    public function getBreadcrumbs(): array
    {
        return [];
    }
}

