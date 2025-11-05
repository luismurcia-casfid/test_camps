<?php

namespace App\Filament\Resources\Seasons\Pages;

use App\Filament\Resources\Seasons\SeasonResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditSeason extends EditRecord
{
    protected static string $resource = SeasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),
            DeleteAction::make(),
        ];
    }
}
