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
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonarResource extends Resource
{
    protected static ?string $model = Donor::class;

    protected static ?string $navigationGroup = 'Config';

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Donor Details')
                    ->description('Donor personal details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->placeholder('Donor Name'),
                        Forms\Components\TextInput::make('phone')->required()->placeholder('Donor Phone'),
                        Forms\Components\TextInput::make('email')->placeholder('E-Mail Address'),
                        Forms\Components\TextInput::make('address')->placeholder('Address'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('phone')
                    ->icon('heroicon-o-clipboard-document')
                    ->iconColor('success')
                    ->fontFamily(FontFamily::Mono)
                    ->copyable()
                    ->copyMessage('Copied!'),

                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('created_at')->since()->label('Created On'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
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
