<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntityResource\Pages;
use App\Filament\Resources\EntityResource\RelationManagers;
use App\Models\Entity;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;

class EntityResource extends Resource
{
    protected static ?string $model = Entity::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Config';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Entity Details')
                    ->description('Enter entity descriptions')
                    ->columns(3)
                    ->schema([
                        Select::make('type')
                            ->label('Entity Type')
                            ->options([
                                'school' => 'School',
                                'church' => 'Church',
                                'children' => 'Children Home',
                            ])
                            ->native(false),

                        TextInput::make('name')
                            ->placeholder('Entity Name')
                            ->columnSpan(2)
                            ->required(),

                        TextInput::make('email')
                            ->placeholder('E-Mail Address')
                            ->required(),

                        TextInput::make('phone')
                            ->placeholder('Phone Number'),

                        TextInput::make('population')
                            ->placeholder('Population')
                            ->minValue(1)
                            ->step(1)
                            ->required()
                            ->numeric(),

                        Textarea::make('address')->label('Address')
                            ->placeholder('Enter physical address')
                            ->columnSpanFull()

                    ])
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
                    ->copyMessageDuration(1500)
                    ->label('Entity Code'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('created_at')->since()->label('Created On'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Entity Details')
                ->description('View entity details')
                ->columns(4)
                ->schema([
                    TextEntry::make('code')
                        ->icon('heroicon-o-clipboard-document')
                        ->iconColor('success')
                        ->fontFamily(FontFamily::Mono)
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500)
                        ->label('Entity Code'),

                    TextEntry::make('name')
                        ->icon('heroicon-o-building-library'),

                    TextEntry::make('phone')
                        ->placeholder('-:-')
                        ->icon('heroicon-o-phone'),

                    TextEntry::make('email')
                        ->icon('heroicon-o-at-symbol')
                        ->label('E-Mail Address'),

                    TextEntry::make('type')->badge(),
                    TextEntry::make('created_at')->date(),
                    TextEntry::make('updated_at')->since(),
                ]),

            Section::make('Distributions')
                ->description('Distributions for this entity')
                ->columns(4)
                ->schema([

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
            'index' => Pages\ListEntities::route('/'),
            'create' => Pages\CreateEntity::route('/create'),
            'view' => Pages\ViewEntity::route('/{record}/view'),
            'edit' => Pages\EditEntity::route('/{record}/edit'),
        ];
    }
}
