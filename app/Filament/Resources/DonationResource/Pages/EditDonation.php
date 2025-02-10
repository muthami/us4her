<?php

namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDonation extends EditRecord
{
    protected static string $resource = DonationResource::class;

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
