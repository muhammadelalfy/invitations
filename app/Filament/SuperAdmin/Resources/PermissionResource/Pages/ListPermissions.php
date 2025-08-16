<?php

namespace App\Filament\SuperAdmin\Resources\PermissionResource\Pages;

use App\Filament\SuperAdmin\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.permissions.plural_label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.actions.create') . ' ' . __('filament.resources.permissions.label')),
        ];
    }
}

