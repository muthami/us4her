<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationLabel = 'Inventory';
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->date(),
                Tables\Columns\TextColumn::make('item.code')
                    ->icon('heroicon-o-clipboard-document')
                    ->iconColor('success')
                    ->fontFamily(FontFamily::Mono)
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->label('Item Code'),

                Tables\Columns\TextColumn::make('item.name')->label('Item Name'),

                Tables\Columns\TextColumn::make('inventoryable_type')
                    ->label('Type')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'donation' => 'heroicon-o-bars-arrow-down',
                        'distribution' => 'heroicon-o-bars-arrow-up',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'distribution' => 'danger',
                        'donation' => 'success',
                    }),


//                Tables\Columns\IconColumn::make('inventoryable_type')
//                    ->icon(fn(string $state): string => match ($state) {
//                        'donation' => 'heroicon-o-bars-arrow-down',
//                        'distribution' => 'heroicon-o-bars-arrow-up',
//                    })->color(fn(string $state): string => match ($state) {
//                        'distribution' => 'danger',
//                        'donation' => 'success',
//                        default => 'gray',
//                    })->label('Type'),

                Tables\Columns\TextColumn::make('quantity')
                    ->fontFamily(FontFamily::Mono)
                    ->weight(FontWeight::Bold)
                    ->numeric()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button()->outlined(),
                Tables\Actions\EditAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Inventory Details')
                ->description('View inventory details')
                ->columns(4)
                ->schema([
                    TextEntry::make('inventoryable_type')
                        ->label('Type')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'distribution' => 'danger',
                            'donation' => 'success',
                        }),
                    TextEntry::make('item.name'),
                    TextEntry::make('item.code')
                        ->icon('heroicon-o-clipboard-document')
                        ->iconColor('success')
                        ->fontFamily(FontFamily::Mono)
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500)
                        ->label('Item Code'),

                    TextEntry::make('quantity')
                        ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Mono)
                        ->size(TextEntry\TextEntrySize::Large)
                        ->numeric(),

                    TextEntry::make('created_at')->date()->label('Date Created'),

                    Fieldset::make('')
                        ->schema([

                        ])
                ])
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
