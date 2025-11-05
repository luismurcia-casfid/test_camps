<?php

namespace App\Filament\Gestor\Pages;

use BackedEnum;
use Filament\Pages\Page;

class Inscripciones extends Page
{
    protected string $view = 'filament.gestor.pages.inscripciones';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Inscripciones';

    protected static ?string $title = 'Inscripciones';

    protected static ?int $navigationSort = 2;

    /**
     * Determina si el usuario puede acceder a esta página
     */
    public static function canAccess(): bool
    {
        return true; // El acceso ya está controlado por canAccessPanel
    }
}
