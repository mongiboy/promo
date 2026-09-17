<?php

namespace App\Filament\Resources\Offers\Schemas;

use App\Enums\PartnerNetwork;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Select::make('shop_id')
                                    ->relationship('shop', 'name')
                                    ->required()
                                    ->columnSpan(2),
                                Select::make('partner_network')
                                    ->options(PartnerNetwork::class)
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('title')
                                    ->columnSpanFull()
                                    ->required(),
                                RichEditor::make('description')
                                    ->columnSpanFull(),
                                TextInput::make('url')
                                    ->url()
                                    ->suffixAction(
                                        Action::make('openUrl')
                                            ->icon('heroicon-o-arrow-top-right-on-square')
                                            ->url(fn ($state) => $state)
                                            ->openUrlInNewTab()
                                    )
                                    ->required()
                                    ->columnSpanFull(),
                                Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->columnSpan(2),
                                Section::make()
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_moderated')
                                                    ->required(),
                                                Toggle::make('is_active')
                                                    ->required(),
                                                Toggle::make('is_rejected')
                                                    ->required(),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                        ]),
                        Grid::make(6)
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        DateTimePicker::make('starts_at')
                                            ->columnSpan(2),
                                        DateTimePicker::make('expires_at')
                                            ->columnSpan(2)
                                            ->columnStart(1),
                                    ])
                                    ->columnSpanFull()
                                    ->columnStart(2),
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('discount'),
                                        TextInput::make('promocode'),
                                    ])
                                    ->columnSpanFull()
                                    ->columnStart(2),
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('manual_sort')
                                            ->required()
                                            ->numeric()
                                            ->default(10),
                                        TextInput::make('rating')
                                            ->numeric(),
                                    ])
                                    ->columnSpanFull()
                                    ->columnStart(2),
                                TextInput::make('erid')
                                    ->columnSpan(2)
                                    ->columnStart(2),
                                TextInput::make('external_id')
                                    ->columnSpan(2)
                                    ->columnStart(2),
                            ])
                    ])
            ]);
    }
}
