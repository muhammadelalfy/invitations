<?php

namespace App\Filament\SuperAdmin\Resources\InvitationResource\Pages;

use App\Filament\SuperAdmin\Resources\InvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.invitations.plural_label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.actions.create') . ' ' . __('filament.resources.invitations.label')),
        ];
    }
}

