<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonarResource\Pages;
use App\Filament\Resources\DonarResource\RelationManagers;
use App\Models\Donor;
use App\Models\Entity;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonarResource extends Resource
{
    protected static ?string $model = Donor::class;

    protected static ?string $navigationGroup = 'Donors';

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('address'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonars::route('/'),
            'create' => Pages\CreateDonar::route('/create'),
            'edit' => Pages\EditDonar::route('/{record}/edit'),
        ];
    }
}
