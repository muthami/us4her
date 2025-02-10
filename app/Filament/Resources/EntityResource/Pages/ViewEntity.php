<?php

namespace App\Filament\Resources\EntityResource\Pages;

use App\Filament\Resources\EntityResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEntity extends ViewRecord
{
    protected static string $resource = EntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->button()
                ->icon('heroicon-o-pencil-square')
                ->outlined()->label('Edit Entity'),
        ];
    }
}
