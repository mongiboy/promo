<?php

namespace App\Traits;

use Carbon\Carbon;

trait ParsesDate
{
    private function parseDate(?string $date, string $format): ?string
    {
        if(!$date) return null;

        try {
            return Carbon::createFromFormat($format, $date)->toDateTimeString();
        } catch(\Exception $e) {
            return null;
        }
    }
}
