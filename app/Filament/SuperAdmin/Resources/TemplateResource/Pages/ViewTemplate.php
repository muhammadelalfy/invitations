<?php

namespace App\Filament\SuperAdmin\Resources\TemplateResource\Pages;

use App\Filament\SuperAdmin\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTemplate extends ViewRecord
{
    protected static string $resource = TemplateResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.view') . ' ' . __('filament.resources.templates.label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label(__('filament.actions.edit')),
        ];
    }
}

