<?php

namespace App\Filament\Resources\Offers\Pages;

use App\Filament\Resources\Offers\OfferResource;
use App\Models\Offer;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Все')
                        ->badge(Offer::all()->count())
                        ->badgeColor('success')
                        ->icon('heroicon-o-list-bullet'),
            'for_moderation' => Tab::make('На модерацию')
                ->modifyQueryUsing(
                    fn (Builder $query) => $query->forModeration()
                )
                ->badge(Offer::query()->forModeration()->count())
                ->badgeColor('warning')
                ->icon('heroicon-o-clock'),
            'active' => Tab::make('Показываются')
                ->modifyQueryUsing(fn (Builder $query) => $query->published())
                ->badge(Offer::query()->published()->count())
                ->badgeColor('success')
                ->icon('heroicon-s-check-badge'),
            'hz' => Tab::make('XZ')
                ->badge(Offer::query()
                    ->where('is_active', true)
                    ->where(function (Builder $query) {
                        $query
                            ->where('expires_at', '>', now())
                            ->orWhereNull('expires_at');
                    })
                    ->count()
                )
                ->badgeColor('success')
                ->icon('heroicon-o-list-bullet'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'for_moderation';
    }
}
