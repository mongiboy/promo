<?php

namespace App\Filament\Resources\Offers\Tables;

use App\Models\Offer;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shop.name')
                    ->label('Магазин')
                    //->extraAttributes(['style' => 'width: 150px;'])
                    ->wrap()
                    ->lineClamp(2)
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Заголовок')
                    //->extraAttributes(['style' => 'width: 250px;'])
                    ->wrap()
                    ->lineClamp(2)
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Описание')
                    //->extraAttributes(['style' => 'width: 350px;'])
                    ->wrap()
                    ->lineClamp(2)
                    ->searchable(),
                TextColumn::make('categories')
                    ->label('Категории')
                    ->getStateUsing(
                        fn ($record) => $record->categories->pluck('name')->toArray()
                    )
                    ->badge(),
                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('discount')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('promocode')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('url')
                    ->label('URL')
                    ->formatStateUsing(fn () => 'Перейти')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                TextColumn::make('manual_sort')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_moderated')
                    ->label('Проверен')
                    ->alignCenter()
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Активен')
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('partner_network')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('external_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('shop')
                    ->relationship('shop', 'name')
            ])
            ->recordActions([
                //EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
