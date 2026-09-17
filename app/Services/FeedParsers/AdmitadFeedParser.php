<?php

namespace App\Services\FeedParsers;

use App\Contracts\OfferFeedParser;
use App\Enums\PartnerNetwork;
use App\Traits\ExtractsDomain;
use App\Traits\ParsesDate;
use Illuminate\Support\Facades\Storage;
use App\Traits\ExtractsErid;

class AdmitadFeedParser implements OfferFeedParser
{
    use ExtractsErid, ExtractsDomain, ParsesDate;

    public function parseFeed(string $path): array
    {
        $filePath = Storage::path($path);

        $handle = fopen($filePath,'r');
        $headers = fgetcsv($handle, separator: ';');
        $offers = [];

        while (($row = fgetcsv($handle, separator: ';')) !== false) {
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

    private function mapToOfferData(array $row): ?array
    {
        if (empty($row['gotolink'])) return null;

        $erid = $this->extractErid($row['gotolink']);

        if ($erid === null) return null;

        return [
            'shop_domain' => $this->extractDomain($row['site']),
            'title' => $row['name'],
            'description' => $row['description'] ?? null,
            'starts_at'  => $this->parseDate($row['date_start'] ?? null, 'Y-m-d H:i:s'),
            'expires_at' => $this->parseDate($row['date_end'] ?? null, 'Y-m-d H:i:s'),
            'discount' => $row['discount'] ?? null,
            'promocode' => $row['species'] === 'action' ? null : $row['promocode'],
            'url' => $row['gotolink'],
            'erid' => $erid,
            'partner_network' => PartnerNetwork::Admitad->value,
            'external_id' => $row['id'],
        ];
    }
}
