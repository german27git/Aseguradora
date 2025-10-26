<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\View\TablesRenderHook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Expr\Cast\Bool_;
use Symfony\Component\Console\Helper\TableStyle;

use function Laravel\Prompts\form;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

                                            // ->Con esto modificamos el Icono 
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ //---Creacion de los componentes del FORM DE USUARIO
                Forms\Components\TextInput::make('name')
                //--->Etiqueta para el campo de Nombre
                ->label('Nombre')
                ->required(),

                Forms\Components\TextInput::make('email')
                ->label('Correo electronico')
                ->email()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->required(),

                Forms\Components\DatePicker::make('email_verified_at')
                ->label('Email Verified At')
                ->default(now()),

                Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrated(fn($state)=> filled($state))
                //-->En esta funcion de abajo declaramos que la contrasenia es solo obligatoria en el form de crear User
                ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        //Definimos la estructura de la tabla o lista
            ->columns([
                tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                

                tables\Columns\TextColumn::make('created_at')
                ->label('Creado en')
                ->dateTime()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            //Acciones de nuestra lista de user
            ->actions([
                tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
