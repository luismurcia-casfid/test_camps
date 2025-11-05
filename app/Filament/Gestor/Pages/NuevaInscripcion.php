<?php

namespace App\Filament\Gestor\Pages;

use BackedEnum;
use Filament\Pages\Page;

class NuevaInscripcion extends Page
{
    protected string $view = 'filament.gestor.pages.nueva-inscripcion';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationLabel = 'Nueva inscripción';

    protected static ?string $title = 'Nueva inscripción';

    protected static ?int $navigationSort = 3;

    /**
     * Determina si el usuario puede acceder a esta página
     */
    public static function canAccess(): bool
    {
        return true; // El acceso ya está controlado por canAccessPanel
    }
}
