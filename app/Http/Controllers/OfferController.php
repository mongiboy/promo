<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\RedirectResponse;

class OfferController extends Controller
{
    public function redirect(Offer $offer): RedirectResponse
    {
        $offer->increment('clicks_count');
        return redirect()->away($offer->url);
    }
}
