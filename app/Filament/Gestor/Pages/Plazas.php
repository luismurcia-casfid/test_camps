<?php

namespace App\Filament\Gestor\Pages;

use BackedEnum;
use Filament\Pages\Page;

class Plazas extends Page
{
    protected string $view = 'filament.gestor.pages.plazas';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Plazas';

    protected static ?string $title = 'Plazas';

    protected static ?int $navigationSort = 1;

    /**
     * Determina si el usuario puede acceder a esta página
     */
    public static function canAccess(): bool
    {
        return true; // El acceso ya está controlado por canAccessPanel
    }
}
