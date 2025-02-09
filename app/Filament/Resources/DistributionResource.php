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
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DistributionResource extends Resource
{
    protected static ?string $model = Distribution::class;
    protected static ?string $navigationGroup = 'Distributions';

    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-up';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Distribution')
                        ->icon('heroicon-m-shopping-bag')
                        ->description('Create distribution entity')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Select::make('entity_id')
                                ->label('Entity/School')
//                                ->required()
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
                        ->icon('heroicon-m-shopping-bag')
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
                Tables\Columns\TextColumn::make('id')->label('Code'),
                Tables\Columns\TextColumn::make('created_at')->date(),
                Tables\Columns\TextColumn::make('entity.name')->label('Entity'),
                Tables\Columns\TextColumn::make('distribution_items_count')
                    ->label('Total Distributions')
                    ->counts('distributionItems')
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
                ->columns(3)
                ->schema([
                    TextEntry::make('entity.name')->label('School Name'),
                    TextEntry::make('entity.email')->label('E-Mail Address'),
                    TextEntry::make('user.name')->label('Created By'),
                    TextEntry::make('entity.population')->label('Total Population'),
                    TextEntry::make('created_at'),
                    TextEntry::make('updated_at')->since(),
                    TextEntry::make('comments')->placeholder('-:-')->columnSpanFull(),
                ]),

            Section::make('Distribution Stats')
                ->description('Distribution data stats')
                ->columns(3)
                ->schema([
                    TextEntry::make('distributionItems_count')->label('Number of Items')->placeholder(0),
                    TextEntry::make('distributionItems_count')->label('Total Distributions')->placeholder(0),
                    TextEntry::make('distributionItems_count')->label('Distribution vs Pupils Ration')->placeholder(0),
                ]),

            Section::make('Distribution Items')
                ->description('Items distributed and their counts')
                ->columns(3)
                ->schema([
                    RepeatableEntry::make('distributionItems')
                        ->columns(2)
                        ->schema([
                            TextEntry::make('item.name'),
                            TextEntry::make('quantity')
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
