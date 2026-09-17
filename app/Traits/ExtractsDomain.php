<?php

namespace App\Traits;

use Illuminate\Support\Uri;

trait ExtractsDomain
{
    private function extractDomain(string $url): string
    {
        return preg_replace('/^www\./', '', Uri::of($url)->host());
    }
}
