<?php

namespace App\Filament\Resources\EntityResource\Pages;

use App\Filament\Resources\EntityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntity extends EditRecord
{
    protected static string $resource = EntityResource::class;

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
