<?php

namespace App\Filament\SuperAdmin\Resources\InvitationResource\Pages;

use App\Filament\SuperAdmin\Resources\InvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvitation extends EditRecord
{
    protected static string $resource = InvitationResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.edit') . ' ' . __('filament.resources.invitations.label');
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

