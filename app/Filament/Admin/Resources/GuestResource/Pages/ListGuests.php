<?php

namespace App\Filament\Admin\Resources\GuestResource\Pages;

use App\Filament\Admin\Resources\GuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuests extends ListRecords
{
    protected static string $resource = GuestResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.guests.plural_label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.actions.create') . ' ' . __('filament.resources.guests.label')),
        ];
    }
}

