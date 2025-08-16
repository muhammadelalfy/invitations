<?php

namespace App\Filament\SuperAdmin\Resources\InvitationResource\Pages;

use App\Filament\SuperAdmin\Resources\InvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

