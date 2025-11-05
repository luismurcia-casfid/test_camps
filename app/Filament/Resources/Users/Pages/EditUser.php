<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

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

    /**
     * Después de actualizar el usuario, sincronizar el rol
     */
    protected function afterSave(): void
    {
        $role = $this->data['role'] ?? 'usuario';

        // Sincronizar el rol (elimina los anteriores y asigna el nuevo)
        $this->record->syncRoles([$role]);
    }
}
