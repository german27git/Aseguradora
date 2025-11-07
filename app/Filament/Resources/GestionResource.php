<?php

namespace App\Filament\Resources;

use App\Models\Cliente;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\GestionResource\Pages;


class GestionResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Gestión';
    protected static ?string $pluralLabel = 'Clientes';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->label('Nombre')->sortable()->searchable(),
                TextColumn::make('apellido')->label('Apellido')->sortable()->searchable(),
                TextColumn::make('cuit')->label('CUIT')->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('telefono')->label('Teléfono'),
            ])
            ->filters([
                SelectFilter::make('has_polizas')
                    ->label('Tiene pólizas')
                    ->options([
                        'yes' => 'Sí',
                        'no' => 'No',
                    ])
                    ->query(function ($query, array $data) {
                        if (($data['value'] ?? null) === 'yes') {
                            $query->has('polizas');
                        } elseif (($data['value'] ?? null) === 'no') {
                            $query->doesntHave('polizas');
                        }
                    }),

            ])
            ->actions([
                Tables\Actions\Action::make('ver_polizas')
                    ->label('Ver pólizas')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record) => static::getUrl('view-cliente-polizas', ['record' => $record]))
                    ->color('primary'),
            ])
            ->defaultSort('nombre');
    }

//    public static function getPages(): array
//{
//    return [
//        'index' => Pages\ListGestions::route('/'),
//        'view-cliente-polizas' => Pages\ViewClientePolizas::route('/{record}/polizas'),
//    ];
//}

public static function getPages(): array
{
    return [
        'index' => Pages\ListGestions::route('/'),
        'view-cliente-polizas' => Pages\ViewClientePolizas::route('/{record}/polizas'),
        'test' => Pages\TestPage::route('/test'),
    ];
}

}
