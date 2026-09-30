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

    public function importFromFile(PartnerNetwork $network, string $filePath): array
    {
        $parser = $this->resolveAdapter($network);
        $offers = $parser->parseFeed($filePath);
        return $this->upsertOffers($offers, $network);
    }

    private function upsertOffers(array $offers, PartnerNetwork $network): array
    {
        $result = [
            'total' => count($offers),
            'skipped' => 0,
            'skipped_shops' => [],
        ];

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

            if ($shopId === null) {
                $result['skipped']++;
                $result['skipped_shops'][$shopDomain] = true;
                continue;
            }

            $offer_hash = hash(
                'sha256',
                $network->value . '|' .
                $shopId . '|' .
                $offer['title'] . '|' .
                ($offer['starts_at'] ? substr($offer['starts_at'], 0, 10) : ''));

            unset($offer['shop_domain']);

            $rows[] = [...$offer,'offer_hash' => $offer_hash, 'shop_id' => $shopId, 'is_active' => true];
        }

        if (empty($rows)) {
            $result['error'] = 'Ни один оффер не подходит';
            return $result;
        }

        DB::transaction(function () use ($network, $rows) {
            Offer::where('partner_network', $network->value)->update(['is_active' => false]);

            Offer::upsert(
                $rows,
                uniqueBy: ['offer_hash'],
                update: ['expires_at', 'url', 'is_active']
            );
        });

        return $result;
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
