<?php

namespace App\Filament\Resources\GestionResource\Pages;

use App\Filament\Resources\GestionResource;
use App\Models\Cliente;
use Filament\Resources\Pages\Page;

class ViewClientePolizas extends Page
{
    protected static string $resource = GestionResource::class;

    protected static string $view = 'filament.resources.gestion-resource.pages.view-cliente-polizas';

    public ?Cliente $record = null;

    public function mount($record): void
{
    // Si viene como objeto (que es lo que pasa con Filament)
    if (is_object($record)) {
        $this->record = Cliente::with([
            'polizas.compania',
            'polizas.bienAsegurado',
            'polizas.tipoCobertura',
        ])->find($record->id_cliente);
    } else {
        // Si alguna vez viene solo el ID
        $this->record = Cliente::with([
            'polizas.compania',
            'polizas.bienAsegurado',
            'polizas.tipoCobertura',
        ])->find($record);
    }

    if (!$this->record) {
        abort(404, 'Cliente no encontrado.');
    }
}
}