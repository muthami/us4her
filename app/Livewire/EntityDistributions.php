<?php

namespace App\Livewire;

use App\Models\Distribution;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class EntityDistributions extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table->query(Distribution::query()->with('distributionItems')->take(10))
            ->columns([
                TextColumn::make('created_at')->date()
            ]);
    }

    public function render()
    {
        return view('livewire.entity-distributions');
    }
}
