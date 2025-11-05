<?php

namespace App\Filament\Resources\Seasons\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;

class SeasonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label('Estado')
                    ->inline(false)
                    ->default(true),
                DateTimePicker::make('starts_at')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->native(false)
                    ->seconds(false),
                DateTimePicker::make('ends_at')
                    ->label('Fecha de Fin')
                    ->required()
                    ->native(false)
                    ->seconds(false),
            ]);
    }
}
