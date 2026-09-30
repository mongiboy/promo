<?php

namespace App\Services\FeedParsers;

use App\Contracts\OfferFeedParser;
use App\Enums\PartnerNetwork;
use App\Traits\ExtractsDomain;
use App\Traits\ParsesDate;
use Illuminate\Support\Facades\Storage;

class AdvcakeFeedParser implements OfferFeedParser
{
    use ExtractsDomain, ParsesDate;

    public function parseFeed (string $path): array
    {
        $filePath = Storage::path($path);

        $handle = fopen($filePath,'r');

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") rewind($handle);

        $headers = fgetcsv($handle, escape: '');
        $offers = [];

        while (($row = fgetcsv($handle, escape: '')) !== false) {
            if (count($row) !== count($headers)) {
                continue; //TODO Логировать проблему
            }

            $data = array_combine($headers, $row);

            $offer = $this->mapToOfferData($data);

            if ($offer === null) continue; //TODO Логировать проблему (нет url или erid)

            $offers[] = $offer;
        }

        fclose($handle);
        return $offers;
    }

    private function mapToOfferData (array $row): ?array
    {
        if (empty($row['Реферальная ссылка'])) return null;

        if($row['Единица скидки'] === 'Рубли') {
            $discount = $row['Скидка'] . '₽';
        } elseif ($row['Единица скидки'] === 'Проценты') {
            $discount = $row['Скидка'] . '%';
        } else {
            $discount = null;
        }


        return [
            'shop_domain' => $this->normalizeShopUrl($row['Оффер']),
            'title' => $row['Привязка к акции'],
            'description' => $row['Условия'] ?? null,
            'starts_at'  => $this->parseDate($row['Дата начала'] ?? null, 'Y-m-d'),
            'expires_at' => $this->parseDate($row['Дата окончания'] ?? null, 'Y-m-d'),
            'discount' => $discount,
            'promocode' => $row['Код'] ?? null,
            'url' => $row['Реферальная ссылка'],
            'partner_network' => PartnerNetwork::Advcake->value,
        ];
    }

    private function normalizeShopUrl (string $shopUrl): string
    {
        return match($shopUrl) {
            'dostavka.magnit.ru (приложение)' => 'magnit.ru',
            'kari.com (Influence)' => 'kari.com',
            default => $shopUrl,
        };
    }
}
