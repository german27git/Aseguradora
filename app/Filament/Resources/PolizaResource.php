<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolizaResource\Pages;
use App\Models\Poliza;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
//Dependencias para la ventana modal de BienAsegurado
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\Action;


class PolizaResource extends Resource
{
    protected static ?string $model = Poliza::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_poliza')
                    ->label('Número de Póliza')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Vigente' => 'Vigente',
                        'Anulada' => 'Anulada',
                    ])
                    ->required()
                    ->native(false),

                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->required(),

                Forms\Components\DatePicker::make('fecha_fin')
                    ->label('Fecha de Fin'),

                Forms\Components\Select::make('seccion')
                    ->label('Sección')
                    ->options([
                        'Auto' => 'Automotores',
                        'Moto' => 'Motovehiculos',
                    ])
                    ->required()
                    ->native(false),

                Forms\Components\TextInput::make('endoso')
                    ->label('Endoso')
                    ->numeric()
                    ->default(0),

                Forms\Components\Select::make('id_cliente')
                    ->label('Cliente')
                    ->relationship('cliente', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload()

                    ->createOptionForm([
                        Forms\Components\TextInput::make('nombre')
                        ->label('Nombre Completo'),

                        Forms\Components\TextInput::make('direccion')
                        ->label('Direccion'),

                        Forms\Components\TextInput::make('cuit')
                        ->label('Cuit'),

                        Forms\Components\TextInput::make('telefono')
                        ->label('Telefono'),

                        Forms\Components\TextInput::make('email')
                        ->label('Email')
                    ]),

                Forms\Components\Select::make('id_compania')
                    ->label('Compañía')
                    ->relationship('compania', 'nombre_compania')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('id_bien_asegurado')
                    ->label('Bien Asegurado')
                    ->relationship('bienAsegurado', 'descripcion')
                    ->required()
                    ->searchable()
                    ->preload()
                    //En este bloque como tenemos asociado el bien con la poliza
                    //podemos traer el form de bienAsegurado para crearlo desde aqui.
                    //Implementacion en el commit 22/08/25
                    ->createOptionForm([
                        Forms\Components\TextInput::make('descripcion')
                            ->label('Descripción')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('modelo')
                            ->label('Modelo')
                            ->required()
                            ->numeric(),

                        Forms\Components\TextInput::make('patente')
                            ->label('Patente')
                            ->required()
                            ->maxLength(10),

                        Forms\Components\TextInput::make('valor')
                            ->label('Valor')
                            ->required()
                            ->numeric(),

                        Forms\Components\TextInput::make('motor')
                            ->label('Motor')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('chasis')
                            ->label('Chasis')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('tipo_vehiculo')
                            ->label('Tipo de Vehículo')
                            ->options([
                                'Auto' => 'Auto',
                                'Moto' => 'Moto',
                                'Pick-Up' => 'Pick-Up',
                                'Camiones' => 'Camiones',
                            ])
                            ->required(),

                        Forms\Components\Select::make('tipo_uso')
                            ->label('Tipo de Uso')
                            ->options([
                                'Particular' => 'Particular',
                                'Comercial' => 'Comercial',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_poliza')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('numero_poliza')
                    ->label('Póliza')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'success' => 'Vigente',
                        'danger' => 'Anulada',
                    ]),

                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Inicio')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('fecha_fin')
                    ->label('Fin')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('seccion')
                    ->label('Sección'),

                Tables\Columns\TextColumn::make('endoso'),

                Tables\Columns\TextColumn::make('compania.nombre_compania')
                    ->label('Compañía')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bienAsegurado.descripcion')
                    ->label('Bien Asegurado')
                    ->action(function ($record, $livewire) {
                        $livewire->dispatch('open-modal', [
                            'id' => 'bien-asegurado-detalle',
                            'recordId' => $record->bienAsegurado->id_bien_asegurado,
        ]);
    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('verBien')
        ->label("")        
        ->icon('heroicon-o-eye')
        ->modalHeading(fn ($record) => 'Bien Asegurado: ' . $record->bienAsegurado->descripcion)

        ->modalButton('Cerrar')
        ->modalContent(fn ($record) => Infolist::make()
    ->record($record->bienAsegurado)
    ->schema([
        \Filament\Infolists\Components\Section::make('Información del Bien Asegurado')
            ->schema([
                \Filament\Infolists\Components\Grid::make(2)
                    ->schema([
                        TextEntry::make('descripcion')->label('Descripción'),
                        TextEntry::make('modelo')->label('Modelo'),
                        TextEntry::make('patente')->label('Patente'),
                        TextEntry::make('valor')->label('Valor')->money('ARS'),
                        TextEntry::make('motor')->label('Motor'),
                        TextEntry::make('chasis')->label('Chasis'),
                        TextEntry::make('tipo_vehiculo')->label('Tipo de Vehículo'),
                        TextEntry::make('tipo_uso')->label('Tipo de Uso'),
                    ]),
            ])
            ->collapsible(false) // opcional: que no se pueda plegar
            ->columns(2), // fuerza columnas más prolijas
    ])
                ),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    tables\Actions\DeleteAction::make(),
                    
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

            
            
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolizas::route('/'),
            'create' => Pages\CreatePoliza::route('/create'),
            'edit' => Pages\EditPoliza::route('/{record}/edit'),
        ];
    }

    public function getTableModals(): array
{
    return [
        'bien-asegurado-detalle' => [
            'infolist' => fn ($recordId) => Infolist::make()
                ->record(\App\Models\BienAsegurado::find($recordId))
                ->schema([
                    TextEntry::make('descripcion')->label('Descripción'),
                    TextEntry::make('modelo')->label('Modelo'),
                    TextEntry::make('patente')->label('Patente'),
                    TextEntry::make('valor')->label('Valor'),
                    TextEntry::make('motor')->label('Motor'),
                    TextEntry::make('chasis')->label('Chasis'),
                    TextEntry::make('tipo_vehiculo')->label('Tipo de Vehículo'),
                    TextEntry::make('tipo_uso')->label('Tipo de Uso'),
                ]),
        ],
    ];
}


}
