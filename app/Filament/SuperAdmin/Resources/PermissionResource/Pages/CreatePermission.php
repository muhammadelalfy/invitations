<?php

namespace App\Filament\SuperAdmin\Resources\PermissionResource\Pages;

use App\Filament\SuperAdmin\Resources\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.create') . ' ' . __('filament.resources.permissions.label');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('filament.messages.created_successfully');
    }
}

