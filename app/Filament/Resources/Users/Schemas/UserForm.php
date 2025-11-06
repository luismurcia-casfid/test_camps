<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(8)
                    ->columnSpanFull(),
                Select::make('role')
                    ->label('Rol')
                    ->helperText('Selecciona el rol del usuario en el sistema')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'administrador' => 'Administrador',
                        'gestor' => 'Gestor',
                        'monitor' => 'Monitor',
                        'usuario' => 'Usuario',
                    ])
                    ->searchable()
                    ->required()
                    ->default('usuario')
                    ->live() // Para actualizar en tiempo real
                    ->dehydrated(false) // No guardar directamente en la BD
                    ->afterStateHydrated(function (Select $component, $state, $record) {
                        // Al cargar, obtener el primer rol del usuario
                        if ($record && $record->roles->isNotEmpty()) {
                            $component->state($record->roles->first()->name);
                        }
                    })
                    ->columnSpanFull(),
            ]);
    }
}
