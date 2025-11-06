<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\Season;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label('Estado')
                    ->inline(false)
                    ->default(true),
                Textarea::make('description')
                    ->label('Descripción')
                    ->rows(3)
                    ->columnSpanFull(),
                Select::make('season_id')
                    ->label('Temporada')
                    ->relationship('season', 'name')
                    ->searchable()
                    ->preload(),
                 DateTimePicker::make('starts_at')
                    ->label('Fecha de Inicio')
                    ->native(false)
                    ->seconds(false),
                DateTimePicker::make('ends_at')
                    ->label('Fecha de Fin')
                    ->native(false)
                    ->seconds(false),
            ]);
    }
}
