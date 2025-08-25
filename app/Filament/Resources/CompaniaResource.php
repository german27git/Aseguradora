<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompaniaResource\Pages;
use App\Models\Compania;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompaniaResource extends Resource
{
    protected static ?string $model = Compania::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nombre_compania')
                ->label('Nombre de la Compañía')
                ->required()
                ->maxLength(255),

            Forms\Components\CheckboxList::make('tiposCobertura')
                ->label('Tipos de Cobertura')
                ->relationship('tiposCobertura', 'nombre')
                ->columns(2)
                ->bulkToggleable(), // seleccionar/deseleccionar todo

            Forms\Components\Select::make('tipo_vigencia')
                ->label('Tipo de Vigencia')
                ->options([
                    'Anual' => 'Anual',
                    'Semestral' => 'Semestral',
                ])
                ->required(),
        ]);
}

public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nombre_compania')
                ->label('Nombre')
                ->searchable()
                ->sortable(),

            Tables\Columns\TagsColumn::make('tiposCobertura.nombre')
                ->label('Coberturas')
                ->limit(3),

            Tables\Columns\TextColumn::make('tipo_vigencia')
                ->label('Vigencia')
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Creado')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Actualizado')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\ViewAction::make()->label(''),
            Tables\Actions\EditAction::make()->label(''),
            Tables\Actions\DeleteAction::make()->label(''),
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
            'index' => Pages\ListCompanias::route('/'),
            'create' => Pages\CreateCompania::route('/create'),
            'edit' => Pages\EditCompania::route('/{record}/edit'),
        ];
    }
}
