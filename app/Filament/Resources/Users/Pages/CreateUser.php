<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Después de crear el usuario, asignar el rol
     */
    protected function afterCreate(): void
    {
        $role = $this->data['role'] ?? 'usuario';

        // Asignar el rol al usuario recién creado
        $this->record->syncRoles([$role]);
    }
}
