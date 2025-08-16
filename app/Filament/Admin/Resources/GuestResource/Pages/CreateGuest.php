<?php

namespace App\Filament\Admin\Resources\GuestResource\Pages;

use App\Filament\Admin\Resources\GuestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGuest extends CreateRecord
{
    protected static string $resource = GuestResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.create') . ' ' . __('filament.resources.guests.label');
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

