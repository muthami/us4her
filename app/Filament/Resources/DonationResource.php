<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Entity;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;
    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-down';
    protected static ?string $navigationGroup = 'Operations';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Create Donation')
                        ->icon('heroicon-o-bars-arrow-down')
                        ->description('Create donation entry')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Select::make('donor_id')
                                ->label('Donor')
//                                ->required()
                                ->placeholder('select donor')
                                ->options(Donor::all()->pluck('name', 'id'))
                                ->searchable(),

                            Forms\Components\DatePicker::make('date')
                                ->label('Donation Date'),

                            Forms\Components\Textarea::make('comments')
                                ->placeholder('Enter any other comments')
                                ->rows(4)
                                ->columnSpanFull()
                        ]),

                    Wizard\Step::make('Donation Items')
                        ->icon('heroicon-o-squares-plus')
                        ->description('Add donation items')
                        ->schema([
                            Forms\Components\Repeater::make('donation_items')
                                ->relationship('donationItems')
                                ->columns(4)
                                ->collapsible()
                                ->schema([
                                    Forms\Components\TextInput::make('id')->label('Product Code')->readOnly(),

                                    Forms\Components\Select::make('item_id')
                                        ->label('Item')
                                        ->options(Item::all()->pluck('name', 'id')->toArray())
                                        ->searchable()
                                        ->required()
                                        ->distinct()
                                        ->columnSpan(2)
                                        ->rule('distinct'),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label('Quantity')
                                        ->numeric()
                                        ->minValue(1)
                                        ->required(),
                                ])
                                ->reorderable(true)
                                ->reorderableWithDragAndDrop(true)
                        ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->icon('heroicon-o-clipboard-document')
                    ->iconColor('success')
                    ->fontFamily(FontFamily::Mono)
                    ->copyable()
                    ->copyMessage('Copied!'),

                Tables\Columns\TextColumn::make('created_at')->date()->label('Donation Date'),
                Tables\Columns\TextColumn::make('donor.name')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('donation_items_count')
                    ->label('Categories')
                    ->counts('donationItems')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_donations')
                    ->weight(FontWeight::Bold)
                    ->fontFamily(FontFamily::Mono)
                    ->label('Donated Items')
                    ->state(fn($record) => $record->donationItems()->sum('quantity'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
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
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'view' => Pages\ViewDonation::route('/{record}/view'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
