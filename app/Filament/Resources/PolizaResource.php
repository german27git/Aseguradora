<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolizaResource\Pages;
use App\Models\Poliza;
use App\Models\Compania;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\Action;
use Carbon\Carbon;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Support\Facades\Storage;



class PolizaResource extends Resource
{
    protected static ?string $model = Poliza::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 🧩 CLIENTE
                Forms\Components\Select::make('id_cliente')
                    ->label('Cliente')
                    ->relationship('cliente', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nombre')->label('Nombre Completo'),
                        Forms\Components\TextInput::make('direccion')->label('Dirección'),
                        Forms\Components\TextInput::make('cuit')->label('CUIT'),
                        Forms\Components\TextInput::make('telefono')->label('Teléfono'),
                        Forms\Components\TextInput::make('email')->label('Email'),
                    ])
                    ->columnSpan('full'),

                // 🚗 BIEN ASEGURADO
                Forms\Components\Select::make('id_bien_asegurado')
    ->label('Bien Asegurado')
    ->relationship('bienAsegurado', 'descripcion')
    ->required()
    ->searchable()
    ->preload()
    ->createOptionForm([
        Forms\Components\TextInput::make('descripcion')->label('Descripción')->required(),
        Forms\Components\TextInput::make('modelo')->label('Modelo')->numeric()->required(),
        Forms\Components\TextInput::make('patente')->label('Patente')->required()->maxLength(10),
        Forms\Components\TextInput::make('valor')->label('Valor')->required()->numeric(),
        Forms\Components\TextInput::make('motor')->label('Motor')->required(),
        Forms\Components\TextInput::make('chasis')->label('Chasis')->required(),
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
        Forms\Components\FileUpload::make('imagenes')
            ->label('Imágenes del Bien')
            ->image()
            ->multiple()
            ->maxFiles(5)
            ->disk('public')
            ->directory('bienes')
            ->nullable()
            ->imagePreviewHeight('150')
            ->formatStateUsing(function ($state) {
                if (is_array($state) && count($state) > 0) {
                    return [$state[0]]; // mostrar solo una preview
                }
                return $state ? [$state] : [];
            }),
    ]) // 👈 este paréntesis y corchete cierran createOptionForm correctamente
    ->columnSpan('full'),

                // 🏢 COMPAÑÍA
                Forms\Components\Select::make('id_compania')
                    ->label('Compañía')
                    ->relationship('compania', 'nombre_compania')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn ($get, $set) => self::ajustarYValidarVigencia($get, $set))
                    ->columnSpan(1),

                // 🧾 TIPO DE COBERTURA
                Forms\Components\Select::make('tipo_cobertura_id')
                    ->label('Tipo de Cobertura')
                    ->options(fn ($get) => $get('id_compania') ? Compania::find($get('id_compania'))?->tiposCobertura->pluck('nombre','id')->toArray() ?? [] : [])
                    ->required()
                    ->reactive()
                    ->visible(fn ($get) => !is_null($get('id_compania')))
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                // 📅 FECHAS
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($get, $set) => self::ajustarYValidarVigencia($get, $set))
                    ->columnSpan(1),

                Forms\Components\DatePicker::make('fecha_fin')
                    ->label('Fecha de Fin (calculada)')
                    ->required()
                    ->reactive()
                    ->readOnly()
                    ->columnSpan(1),

                // ⚙️ SECCIÓN
                Forms\Components\Select::make('seccion')
                    ->label('Sección')
                    ->options([
                        'Auto' => 'Automotores',
                        'Moto' => 'Motovehículos',
                    ])
                    ->required()
                    ->native(false)
                    ->columnSpan(1),

                // 🔢 NÚMERO DE PÓLIZA
                Forms\Components\TextInput::make('numero_poliza')
                    ->label('Número de Póliza')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),

                // 🟢 ESTADO (solo al editar)
                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Vigente' => 'Vigente',
                        'Anulada' => 'Anulada',
                    ])
                    ->default('Vigente')
                    ->visible(fn ($context) => $context === 'edit')
                    ->required()
                    ->native(false)
                    ->columnSpan(1),

                // 🔵 ENDOSO (solo al editar)
                Forms\Components\TextInput::make('endoso')
                    ->label('Endoso')
                    ->numeric()
                    ->default(0)
                    ->visible(fn ($context) => $context === 'edit')
                    ->columnSpan(1),
            ])
            ->columns(2);
    }

    protected static function ajustarYValidarVigencia(callable $get, callable $set)
    {
        $companiaId = $get('id_compania');
        $fechaInicio = $get('fecha_inicio');
        if (!$companiaId || !$fechaInicio) return;
        $compania = Compania::find($companiaId);
        if (!$compania) return;

        $dias = match ($compania->tipo_vigencia) {
            'Anual' => 365,
            'Semestral' => 180,
            default => null,
        };

        if ($dias) {
            $set('fecha_fin', Carbon::parse($fechaInicio)->addDays($dias)->toDateString());
        }
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id_poliza')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('cliente.nombre')->label('Cliente')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('numero_poliza')->label('Póliza')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('estado')->label('Estado')->badge()->colors([
                'success' => 'Vigente',
                'danger' => 'Anulada',
            ]),
            Tables\Columns\TextColumn::make('fecha_inicio')->label('Inicio')->date('d/m/Y'),
            Tables\Columns\TextColumn::make('fecha_fin')->label('Fin')->date('d/m/Y'),
            Tables\Columns\TextColumn::make('seccion')->label('Sección'),
            Tables\Columns\TextColumn::make('endoso')->label('Endoso'),
            Tables\Columns\TextColumn::make('compania.nombre_compania')->label('Compañía')->sortable(),
            Tables\Columns\TextColumn::make('bienAsegurado.descripcion')->label('Bien Asegurado'),

            // Columna que pasa URLs al blade (ViewColumn)
            ViewColumn::make('imagenes')
    ->label('Imágenes')
    ->getStateUsing(function ($record) {
        $imagenes = $record->bienAsegurado?->imagenes ?? [];

        if (is_string($imagenes)) {
            $imagenes = json_decode($imagenes, true) ?? [];
        }

        // Filtramos vacíos y obtenemos solo la primera imagen
        $imagenesArray = collect($imagenes)
            ->filter(fn ($img) => !empty($img))
            ->map(fn ($img) => Storage::disk('public')->url($img))
            ->toArray();

        return $imagenesArray ? [$imagenesArray[0]] : [];
    })
    ->view('filament.columns.bien-imagenes'),
        ])
        ->actions([
    Action::make('verBien')
        ->label('')
        ->icon('heroicon-o-eye')
        ->modalHeading(fn ($record) => 'Bien Asegurado: ' . ($record->bienAsegurado?->descripcion ?? ''))
        ->modalButton('Cerrar')
        ->modalContent(function ($record) {

            $bien = $record->bienAsegurado; // Capturamos la relación

            return Infolist::make()
                ->record($bien) // El record del Infolist
                ->schema([
                    // Información principal
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
                        ]),

                    // Imágenes
                    \Filament\Infolists\Components\Section::make('Imágenes del Bien Asegurado')
                        ->schema([
                            \Filament\Infolists\Components\ViewEntry::make('imagenes')
                                ->view('filament.columns.bien-imagenes')
                                ->getStateUsing(function ($record) {
                                    $imagenes = $record?->imagenes ?? [];

                                    if (is_string($imagenes)) {
                                        $imagenes = json_decode($imagenes, true) ?? [];
                                    }

                                    return collect($imagenes)
                                        ->map(fn($img) => \Illuminate\Support\Facades\Storage::disk('public')->url($img))
                                        ->toArray();
                                }),
                        ]),
                ]);
        }),

            // Grupo estándar de acciones (ver/editar/eliminar)
            Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolizas::route('/'),
            'create' => Pages\CreatePoliza::route('/create'),
            'edit' => Pages\EditPoliza::route('/{record}/edit'),
        ];
    }
}
