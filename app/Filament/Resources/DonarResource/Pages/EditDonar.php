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
            Actions\ViewAction::make()
                ->icon('heroicon-o-arrow-uturn-left')
                ->button()
                ->outlined()
                ->label('Go Back'),

            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->button()
                ->requiresConfirmation()
                ->outlined()
        ];
    }
}
