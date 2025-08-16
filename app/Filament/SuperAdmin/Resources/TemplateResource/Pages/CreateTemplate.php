<?php

namespace App\Filament\SuperAdmin\Resources\TemplateResource\Pages;

use App\Filament\SuperAdmin\Resources\TemplateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTemplate extends CreateRecord
{
    protected static string $resource = TemplateResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.create') . ' ' . __('filament.resources.templates.label');
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

