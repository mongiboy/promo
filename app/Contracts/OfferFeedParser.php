<?php

namespace App\Contracts;

interface OfferFeedParser
{
    public function parseFeed(string $path): array;
}
