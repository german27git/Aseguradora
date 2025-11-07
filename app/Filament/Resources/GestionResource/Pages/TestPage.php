<?php

namespace App\Filament\Resources\GestionResource\Pages;

use App\Filament\Resources\GestionResource;
use Filament\Resources\Pages\Page;

class TestPage extends Page
{
    protected static string $resource = GestionResource::class;

    protected static string $view = 'filament.resources.gestion-resource.pages.test';
}