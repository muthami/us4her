<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDistribution extends EditRecord
{
    protected static string $resource = DistributionResource::class;

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
