<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $ruAlphabet = ['А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'];
        $enAlphabet = range('A', 'Z');

        $shops = Shop::query()
            ->visible()
            ->orderBy('name')
            ->get()
            ->groupBy(function ($shop) {
                $firstChar = mb_strtoupper(mb_substr($shop->name, 0, 1));
                return ctype_digit($firstChar) ? '0-9' : $firstChar;
            });

        $breadcrumbs = collect([
            [
                'title' => 'Магазины',
                'route' => route('shops.index')
            ],
        ]);

        return view('shops.index', compact('shops', 'ruAlphabet', 'enAlphabet', 'breadcrumbs'));
    }

    public function show(Shop $shop, Request $request): View
    {
        $offers = $shop->offers()->published()->get();

        $categoryIds = DB::table('category_offer')
            ->whereIn('offer_id', $offers->pluck('id'))
            ->pluck('category_id')
            ->unique();

        $similarShops = Shop::query()
            ->visible()
            ->whereKeyNot($shop->id)
            ->whereHas('offers', function ($query) use ($categoryIds) {
                $query->published()->whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                });
            })
            ->limit(6)
            ->orderBy('sort')
            ->get();

        $breadcrumbs = collect([
            [
                'title' => 'Магазины',
                'route' => route('shops.index')
            ],
            [
                'title' => $shop->name,
                'route' => route('shops.show', $shop)
            ],
        ]);

        return view('shops.show', compact('shop', 'offers', 'similarShops','breadcrumbs'));
    }
}
