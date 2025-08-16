<?php

namespace App\Filament\SuperAdmin\Resources\TemplateResource\Pages;

use App\Filament\SuperAdmin\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemplates extends ListRecords
{
    protected static string $resource = TemplateResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.templates.plural_label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.actions.create') . ' ' . __('filament.resources.templates.label')),
        ];
    }
}

