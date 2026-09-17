<?php

namespace App\Filament\Resources\Shops\Schemas;

use App\Enums\PartnerNetwork;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_active'),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('alt_name'),
                RichEditor::make('seo_text')
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                TextInput::make('logo'),
                Textarea::make('aliases')
                    ->columnSpanFull(),
                Select::make('networks')
                    ->multiple()
                    ->options(PartnerNetwork::class),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(999),
            ]);
    }
}
