<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('slug')
                                    ->required(),
                                TextInput::make('meta_title')
                                    ->columnSpanFull(),
                                TextInput::make('meta_description')
                                    ->columnSpanFull(),
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('sort')
                                            ->required()
                                            ->numeric()
                                            ->default(999),

                                        Toggle::make('is_active')
                                            ->required(),
                                    ])
                            ]),
                        RichEditor::make('seo_text'),
                    ]),
            ]);
    }
}
