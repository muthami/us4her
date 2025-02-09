<?php

namespace App\Filament\Resources\DonarResource\Pages;

use App\Filament\Resources\DonarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDonar extends EditRecord
{
    protected static string $resource = DonarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
