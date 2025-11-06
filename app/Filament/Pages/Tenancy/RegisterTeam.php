<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Course;
use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Nuevo curso';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('slug'),
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
                Toggle::make('is_active')
                    ->label('Estado')
                    ->inline(false)
                    ->default(true),
            ]);
    }

    protected function handleRegistration(array $data): Course
    {
        $course = Course::create($data);

        // $team->members()->attach(auth()->user());

        return $course;
    }
}
