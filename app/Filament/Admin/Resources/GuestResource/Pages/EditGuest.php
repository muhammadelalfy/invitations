<?php

namespace App\Filament\Admin\Resources\GuestResource\Pages;

use App\Filament\Admin\Resources\GuestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuest extends EditRecord
{
    protected static string $resource = GuestResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.edit') . ' ' . __('filament.resources.guests.label');
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

