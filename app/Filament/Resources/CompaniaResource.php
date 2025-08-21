<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompaniaResource\Pages;
use App\Filament\Resources\CompaniaResource\RelationManagers;
use App\Models\Compania;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompaniaResource extends Resource
{
    protected static ?string $model = Compania::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_compania')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipo_cobertura')
                    ->required(),
                Forms\Components\TextInput::make('tipo_vigencia')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_compania')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_cobertura'),
                Tables\Columns\TextColumn::make('tipo_vigencia'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCompanias::route('/'),
            'create' => Pages\CreateCompania::route('/create'),
            'edit' => Pages\EditCompania::route('/{record}/edit'),
        ];
    }
}
