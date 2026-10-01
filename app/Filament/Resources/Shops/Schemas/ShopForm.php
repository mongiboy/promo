<?php

namespace App\Filament\Resources\Shops\Schemas;

use App\Enums\PartnerNetwork;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('name')
                                    ->columnSpan(2)
                                    ->required(),
                                TextInput::make('alt_name')
                                    ->columnSpan(2),
                                TextInput::make('slug')
                                    ->columnSpan(2)
                                    ->required(),
                                TextInput::make('url')
                                    ->columnSpan(2)
                                    ->url()
                                    ->required(),
                                FileUpload::make('logo')
                                    ->label('Логотип')
                                    ->openable()
                                    ->disk('public')
                                    ->directory('shops')
                                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                                        return $get('slug') . '.' . $file->getClientOriginalExtension();
                                    })
                                    ->acceptedFileTypes([
                                        'image/jpeg',
                                        'image/png',
                                        'image/webp',
                                        'image/svg+xml',
                                    ])
                                    ->columnSpan(2)
                                    ->required(),

                                Textarea::make('aliases')
                                    ->columnSpan(2),
                                TextInput::make('meta_title')
                                    ->columnSpanFull(),
                                TextInput::make('meta_description')
                                    ->columnSpanFull(),
                                Select::make('networks')
                                    ->multiple()
                                    ->options(PartnerNetwork::class)
                                    ->columnSpan(2),
                                Select::make('category_id')
                                    ->options(Category::pluck('name', 'id'))
                                    ->columnSpan(2),
                                Toggle::make('is_active')
                                    ->columnStart(1),
                            ])
                            ->columnSpanFull()
                        ]),
                        Grid::make(3)
                            ->schema([
                                RichEditor::make('seo_text')
                                    ->columnSpanFull(),
                            ]),
            ]);
/*



                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(999),
*/
    }
}
