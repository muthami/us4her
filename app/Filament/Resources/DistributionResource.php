<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistributionResource\Pages;
use App\Filament\Resources\DistributionResource\RelationManagers;
use App\Models\Distribution;
use App\Models\Entity;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Table;

class DistributionResource extends Resource
{
    protected static ?string $model = Distribution::class;
    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-up';
    protected static ?string $navigationGroup = 'Operations';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Distribution')
                        ->icon('heroicon-o-bars-arrow-up')
                        ->description('Create distribution entity')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Select::make('entity_id')
                                ->label('Entity/School')
                                ->required()
                                ->placeholder('select entity')
                                ->options(Entity::all()->pluck('name', 'id'))
                                ->searchable(),

                            Forms\Components\DatePicker::make('date')
                                ->label('Distribution Date'),

                            Forms\Components\Textarea::make('comments')
                                ->placeholder('Enter any other comments')
                                ->rows(4)
                                ->columnSpanFull()
                        ]),

                    Wizard\Step::make('Distribution Items')
                        ->icon('heroicon-o-squares-plus')
                        ->description('Add distributed items')
                        ->schema([
                            Forms\Components\Repeater::make('distribution_items')
                                ->relationship('distributionItems')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('item_id')
                                        ->label('Item')
                                        ->options(Item::all()->pluck('name', 'id')->toArray())
                                        ->searchable()
                                        ->required()
                                        ->distinct()
                                        ->rule('distinct'),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label('Quantity')
                                        ->numeric()
                                        ->minValue(1)
                                        ->required(),
                                ])
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
                    ->copyMessage('Copied!')
                    ->label('Dist Code'),
                Tables\Columns\TextColumn::make('date')->date(),
                Tables\Columns\TextColumn::make('entity.name')->label('Entity'),
                Tables\Columns\TextColumn::make('distribution_items_count')
                    ->label('Item Categories')
                    ->counts('distributionItems')
                    ->weight(FontWeight::Bold)
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('distributions')
                    ->weight(FontWeight::Bold)
                    ->fontFamily(FontFamily::Mono)
                    ->label('Distributed Items')
                    ->state(fn($record) => $record->distributionItems()->sum('quantity'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button()->outlined(),
                Tables\Actions\EditAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Distribution')
                ->description('Distribution details')
                ->columns(4)
                ->schema([
                    TextEntry::make('code')
                        ->icon('heroicon-o-clipboard-document')
                        ->iconColor('success')
                        ->fontFamily(FontFamily::Mono)
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->label('Distribution Code'),

                    TextEntry::make('entity.name')
                        ->icon('heroicon-o-building-library')
                        ->label('School Name'),

                    TextEntry::make('date')->date()->label('Distribution Date'),

                    TextEntry::make('entity.email')
                        ->icon('heroicon-o-at-symbol')
                        ->label('E-Mail Address'),

                    TextEntry::make('user.name')->label('Created By'),
                    TextEntry::make('entity.population')
                        ->weight(FontWeight::Bold)
                        ->state(fn($record) => $record->distributionItems()->sum('quantity'))
                        ->label('Total Distribution'),

                    TextEntry::make('created_at')->date()->label('Date Created'),
                    TextEntry::make('updated_at')->since(),
                    TextEntry::make('comments')->placeholder('-:-')->columnSpanFull(),
                ]),

            Section::make('Distribution Items')
                ->description('Items distributed and their counts')
                ->columns(3)
                ->schema([
                    RepeatableEntry::make('distributionItems')
                        ->columns(4)
                        ->schema([
                            TextEntry::make('item.code')
                                ->icon('heroicon-o-clipboard-document')
                                ->iconColor('success')
                                ->fontFamily(FontFamily::Mono)
                                ->copyable()
                                ->copyMessage('Copied!')
                                ->label('Item Code'),

                            TextEntry::make('item.name'),
                            TextEntry::make('quantity'),

                            TextEntry::make('item.inventory')->label('Current Inventory')
                            ->weight(FontWeight::Bold),
                        ])->columnSpanFull()
                ])
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
            'index' => Pages\ListDistributions::route('/'),
            'create' => Pages\CreateDistribution::route('/create'),
            'view' => Pages\ViewDistribution::route('/{record}'),
            'edit' => Pages\EditDistribution::route('/{record}/edit'),
        ];
    }
}
