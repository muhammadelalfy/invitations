<?php

namespace App\Filament\SuperAdmin\Resources\PermissionResource\Pages;

use App\Filament\SuperAdmin\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.edit') . ' ' . __('filament.resources.permissions.label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label(__('filament.actions.delete'))
                ->successNotificationTitle(__('filament.messages.deleted_successfully')),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament.messages.updated_successfully');
    }
}

