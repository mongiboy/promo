<?php

namespace App\Traits;

use Illuminate\Support\Uri;

trait ExtractsErid
{
    private function extractErid(string $url): ?string
    {
        return Uri::of($url)->query()->get('erid');
    }
}
