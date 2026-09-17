<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SitemapController extends Controller
{

    public function __invoke(Request $request)
    {
        $shops = Shop::query()
            ->where('is_active', true)
            ->withMax([
                'offers as offers_max_updated_at' => fn (Builder $query) => $query->published(),
            ], 'updated_at')
            ->get(['slug', 'updated_at']);

        $shops->each(function ($shop) {
            $shop->sitemap_lastmod = $shop->updated_at->max(
                $shop->offers_max_updated_at
            );
        });

        return response()
            ->view('sitemap', compact('shops'))
            ->header('Content-Type', 'application/xml');
    }
}
