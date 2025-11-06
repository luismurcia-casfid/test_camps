<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Course;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Nuevo curso';
    }

    public static function canView(?Model $tenant = null): bool
    {
        return true;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del Curso')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(Course::class, 'slug')
                    ->maxLength(255)
                    ->helperText('Usado en la URL, ej: curso-laravel-2025'),
                Select::make('season_id')
                    ->label('Temporada')
                    ->relationship('season', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
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

        return $course;
    }
}
