<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    public function __invoke(): View
    {
        $allShops = Shop::query()
            ->visible()
            ->count();

        $allOffers = Offer::query()
            ->published()
            ->count();

        $popularShops = Shop::query()
            ->visible()
            ->orderBy('sort')
            ->limit(12)
            ->get();

        $popularOffers = Offer::query()
            ->published()
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $latestOffers = Offer::query()
            ->published()
            ->latest()
            ->limit(6)
            ->get();


        return view('main', compact('popularShops', 'popularOffers', 'latestOffers', 'allShops', 'allOffers'));
    }
}
