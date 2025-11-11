<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BienAseguradoResource\Pages;
use App\Models\BienAsegurado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BienAseguradoResource extends Resource
{
    protected static ?string $model = BienAsegurado::class;

    // Oculta de la navegación de la barra lateral
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descripcion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('modelo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('patente')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('valor')
                    ->label('$ Valor (ARS)')
                    //->money('ARS')
                    ->prefix('ARS')
                    ->numeric()
                    ->required()
                    ->inputMode('decimal')
                    ->default(0.00)
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(9999999999.99)
                    ->suffix('ARS'),
                Forms\Components\TextInput::make('motor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('chasis')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tipo_vehiculo')
                    ->options([
                        'Auto' => 'Auto',
                        'Moto' => 'Moto',
                        'Pick-Up' => 'Pick-Up',
                        'Camiones' => 'Camiones',
                    ])
                    ->required(),
                Forms\Components\Select::make('tipo_uso')
                    ->options([
                        'Particular' => 'Particular',
                        'Comercial' => 'Comercial',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('imagenes')
                    ->label('Imágenes del Bien')
                    ->image()
                    ->multiple()
                    ->maxFiles(5) // opcional, límite de imágenes
                    ->disk('public')
                    ->directory('bienes')
                    ->nullable()
                    ->imagePreviewHeight('200'),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('descripcion')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('modelo')->sortable(),
            Tables\Columns\TextColumn::make('patente')->sortable(),
            Tables\Columns\TextColumn::make('valor')->sortable(),
            Tables\Columns\TextColumn::make('tipo_vehiculo'),
            Tables\Columns\TextColumn::make('tipo_uso'),
            Tables\Columns\ImageColumn::make('imagenes.0') // <-- Muestra la primera imagen
                ->label('Imagen')
                ->disk('public')
                ->rounded(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBienAsegurados::route('/'),
            'create' => Pages\CreateBienAsegurado::route('/create'),
            'edit' => Pages\EditBienAsegurado::route('/{record}/edit'),
        ];
    }
}
