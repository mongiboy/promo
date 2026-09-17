<?php

namespace App\Services;

use App\Contracts\OfferFeedParser;
use App\Enums\PartnerNetwork;
use App\Models\Offer;
use App\Models\Shop;
use App\Services\FeedParsers\AdmitadFeedParser;
use App\Services\FeedParsers\AdvcakeFeedParser;
use App\Traits\ExtractsDomain;
use Illuminate\Support\Facades\DB;

class OfferImportService
{
    use ExtractsDomain;

    public function importFromFile(PartnerNetwork $network, string $filePath): ?int
    {
        $parser = $this->resolveAdapter($network);
        $offers = $parser->parseFeed($filePath);
        return $this->upsertOffers($offers, $network);
    }

    private function upsertOffers(array $offers, PartnerNetwork $network): ?int
    {
        $shopIdsByDomain = Shop::query()
            ->pluck('url', 'id')
            ->mapWithKeys(fn (string $url, int|string $id) => [
                $this->extractDomain($url) => (int) $id
            ]);

        $rows = [];
        foreach ($offers as $offer) {
            $shopDomain = $offer['shop_domain'];
            if ($shopDomain === 'aliexpress.com') continue;

            $shopId = $shopIdsByDomain[$shopDomain] ?? null;
            unset($offer['shop_domain']);

            if ($shopId == null) continue;

            $rows[] = [...$offer, 'shop_id' => $shopId, 'is_active' => true];
        }

        if (empty($rows)) return null;

        DB::transaction(function () use ($network, $rows) {
            Offer::where('partner_network', $network->value)->update(['is_active' => false]);

            Offer::upsert(
                $rows,
                uniqueBy: ['erid'],
                update: ['expires_at', 'url', 'is_active']
            );
        });

        return count($rows);

    }

    private function resolveAdapter(PartnerNetwork $network): OfferFeedParser
    {
        return match ($network) {
            PartnerNetwork::Admitad => app(AdmitadFeedParser::class),
            PartnerNetwork::Pampadu => throw new \Exception('Pampadu to be implemented'),
            PartnerNetwork::Advcake => app(AdvcakeFeedParser::class),
            PartnerNetwork::GdeSlon => throw new \Exception('GdeSlon to be implemented'),
            PartnerNetwork::Advertise => throw new \Exception('Advertise don`t be implemented'),
        };
    }
}
