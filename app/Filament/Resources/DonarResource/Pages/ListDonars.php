<?php

namespace App\Filament\Resources\DonarResource\Pages;

use App\Filament\Resources\DonarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDonars extends ListRecords
{
    protected static string $resource = DonarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->outlined()->icon('heroicon-o-plus'),
        ];
    }
}
